<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;
use App\Models\TicketPrice;
use App\Models\BusLocationSequence;
use App\Models\BookingSequence;
use App\Repositories\ChannelRepository;
use App\Models\OdbusCharges;
use App\Models\BusOperator;
use App\Models\AgentWallet;
use App\Models\ClientWallet;
use App\Models\ClientFeeSlab;
use App\Models\AgentFee;
use App\Models\Users;
use App\Services\ViewSeatsService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class ClientBookingRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $user;
    protected $booking;
    protected $busSeats;
    protected $busLocationSequence;
    protected $viewSeatsService; 
    protected $channelRepository; 

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,User $user,BusSeats $busSeats,Booking $booking,BusLocationSequence $busLocationSequence,ChannelRepository $channelRepository,ViewSeatsService $viewSeatsService)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->user = $user;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->channelRepository = $channelRepository;
        $this->busLocationSequence = $busLocationSequence;
        $this->viewSeatsService = $viewSeatsService;    
    }   
    
    public function clientBooking($request)
    {  
        $needGstBill = Config::get('constants.NEED_GST_BILL');
        $customerInfo = $request['customerInfo'];
        $bookingInfo = $request['bookingInfo'];
        $defUserId = Config::get('constants.USER_ID');
        $busOperatorId = Bus::where('id',$bookingInfo['bus_id'])->first()->bus_operator_id;

        $clientId = $this->user->where('id',$bookingInfo['user_id'])
                                ->where('status','1')
                                ->first('id');

        $existingUser = Users::where('phone',$customerInfo['phone'])
                                    ->exists(); 
        if($existingUser==true){
            $userId = Users::where('phone',$customerInfo['phone'])
                                  ->first()->id;
            Users::where('id', $userId)->update($customerInfo);     
        }
        else{
            $userId = Users::create($request['customerInfo'])->latest()->first()->id;   
        }
        if(isset($bookingInfo['user_id'])){
         $walletDetail = ClientWallet::where('user_id',$bookingInfo['user_id'])->orderBy('id','DESC')->where("status",1)->limit(1)->get();
       
         $walletBalance=0;

        if(isset($walletDetail[0])){
            $walletBalance = $walletDetail[0]->balance;
        }else{
            $arr['note']="You do not have any wallet balance. Kindly recharge your wallet to book tickets";
            $arr['message']="less_balance";
            return $arr;
        } 
    if($walletBalance >= $bookingInfo['total_fare']){
        //Save Booking 
               $booking = new $this->booking;
        do {
           $transactionId = date('YmdHis') . gettimeofday()['usec'];
           } while ( $booking ->where('transaction_id', $transactionId )->exists());
        $booking->transaction_id =  $transactionId;
        do {
            $PNR = 'ODW'.rand(100000,999999);
            } while ( $booking ->where('pnr', $PNR )->exists()); 
        $booking->pnr = $PNR;
        $booking->user_id = $bookingInfo['user_id'];
        $booking->bus_id = $bookingInfo['bus_id'];
        $busId = $bookingInfo['bus_id'];
        $booking->source_id = $bookingInfo['source_id'];
        $booking->destination_id =  $bookingInfo['destination_id'];
        $ticketPriceDetails = $this->ticketPrice->where('bus_id',$busId)->where('source_id',$bookingInfo['source_id'])
                                                ->where('destination_id',$bookingInfo['destination_id'])->get();
        $booking->j_day = $ticketPriceDetails[0]->j_day;
        $booking->journey_dt = $bookingInfo['journey_dt'];
        $booking->boarding_point = $bookingInfo['boarding_point'];
        $booking->dropping_point = $bookingInfo['dropping_point'];
        $booking->boarding_time = $bookingInfo['boarding_time'];
        $booking->dropping_time =  $bookingInfo['dropping_time'];
        $booking->origin = $bookingInfo['origin'];
        $booking->app_type = $bookingInfo['app_type'];
        $booking->typ_id = $bookingInfo['typ_id'];
        $booking->owner_fare = $bookingInfo['owner_fare'];
        $booking->total_fare = $bookingInfo['total_fare'];
        $booking->odbus_Charges = $bookingInfo['odbus_service_Charges'];
        $booking->transactionFee = $bookingInfo['transactionFee'];

        $odbusGstPercent = OdbusCharges::where('user_id',$defUserId)->first()->odbus_gst_charges;
      
        $booking->odbus_gst_charges = $odbusGstPercent;
        $odbusGstAmount = $bookingInfo['owner_fare'] * $odbusGstPercent/100;
        $booking->odbus_gst_amount = $odbusGstAmount;
        
        $busOperator = BusOperator::where("id",$busOperatorId)->get();   
        
            if($busOperator[0]->need_gst_bill == $needGstBill){   
                $ownerGstPercentage = $busOperator[0]->gst_amount;
                $booking->owner_gst_charges = $ownerGstPercentage;
                $ownerGstAmount = $bookingInfo['owner_fare'] * $ownerGstPercentage/100;
                $booking->owner_gst_amount = $ownerGstAmount;
            }     
        $clientCommissions = ClientFeeSlab::get(); 
        
        $clientComission = 0;
        if($clientCommissions){
            foreach($clientCommissions as $clientCom){
                $startFare = $clientCom->starting_fare;
                $uptoFare = $clientCom->upto_fare;
                if($bookingInfo['total_fare'] >= $startFare && $bookingInfo['total_fare']<= $uptoFare){
                    $clientComission = $clientCom->commision;
                    break;
                }  
            }   
        } 
        $clientComAmount = round($clientComission/100 * $bookingInfo['total_fare'],2);
        $booking->client_comission = $clientComAmount;
        $booking->client_percentage = $clientComission;
                       
        $booking->created_by = $bookingInfo['created_by'];
        $booking->users_id = $userId;
        $clientId->booking()->save($booking);
        
        //fetch the sequence from bus_locaton_sequence
        $seq_no_start = $this->busLocationSequence->where('bus_id',$busId)->where('location_id',$bookingInfo['source_id'])->first()->sequence;
        $seq_no_end = $this->busLocationSequence->where('bus_id',$busId)->where('location_id',$bookingInfo['destination_id'])->first()->sequence;
        
        $bookingSequence = new BookingSequence;
        $bookingSequence->sequence_start_no = $seq_no_start;
        $bookingSequence->sequence_end_no = $seq_no_end;
            
        $booking->bookingSequence()->save($bookingSequence);

        //Update Booking Details >>>>>>>>>>
  
        $ticketPriceId = $ticketPriceDetails[0]->id;
        $bookingDetail = $request['bookingInfo']['bookingDetail'];
        $seatIds = Arr::pluck($bookingDetail, 'bus_seats_id');  ////////in request passing seats_id with key as bus_seats_id
        foreach ($seatIds as $seatId){
            $busSeatsId[] = $this->busSeats
                ->where('bus_id',$busId)
                ->where('ticket_price_id',$ticketPriceId)
                ->where('seats_id',$seatId)->first()->id;
        }  
        $bookingDetailModels = [];  
        $i=0;
       foreach ($bookingInfo['bookingDetail'] as $bDetail) {
            $collection= collect($bDetail);
            $merged = ($collection->merge(['bus_seats_id' => $busSeatsId[$i]]))->toArray();
            $bookingDetailModels[] = new BookingDetail($merged);
            $i++;
        }    
        $booking->bookingDetail()->saveMany($bookingDetailModels);      
        return $booking; 
        }
        else{
            $arr['note']="Your current wallet balance is ₹ ".$walletBalance." Kindly recharge your wallet to book tickets";
            $arr['message']="less_balance";
            return $arr;
            } 
     }else{
         return 'CLIENT_INVALID';
     }
    }

    public function ticketConfirmation($request)
    {
        $booked = Config::get('constants.BOOKED_STATUS');
        $transactionId = $request['transaction_id'];
        $bookingRecord = $this->booking->where('transaction_id', $transactionId)
                                       ->with('bookingDetail')
                                       ->get();

        $bookingId = $bookingRecord[0]->id; 
        $comissionAmount = $bookingRecord[0]->client_comission;             
        $amount = $bookingRecord[0]->total_fare;
                              
        $walletBalance = ClientWallet::where('user_id',$request['client_id'])->where('status',1)->latest()->first()->balance;
      
        $clientWallet = new ClientWallet();
        $clientWallet->transaction_id = $transactionId;
        $clientWallet->booking_id = $bookingId;
        $clientWallet->amount = $amount;
        $clientWallet->transaction_type = 'd';
        $clientWallet->balance = $walletBalance - $amount;
        $clientWallet->user_id = $request['client_id'];
        $clientWallet->created_by = $request['client_name'];
        $clientWallet->status = 1;
        $clientWallet->save();
        //return $clientWallet;

        $walletBalance = ClientWallet::where('user_id',$request['client_id'])->latest()->first()->balance;
        $tranId = date('YmdHis') . gettimeofday()['usec'];
        $clientWallet = new ClientWallet();
        $clientWallet->transaction_id = $tranId;
        $clientWallet->amount = $comissionAmount;
        $clientWallet->type = 'Commission';
        $clientWallet->booking_id = $bookingId;
        $clientWallet->transaction_type = 'c';
        $clientWallet->balance = $walletBalance + $comissionAmount;
        $clientWallet->user_id = $request['client_id'];
        $clientWallet->created_by = $request['client_name'];
        $clientWallet->status = 1;
        $clientWallet->save();

        /////////Update booking table as status booked////////////
  
        $this->booking->where('id', $bookingId)->update(['status' => $booked]);
        $booking = $this->booking->find($bookingId);
        $booking->bookingDetail()->where('booking_id', $bookingId)->update(array('status' => $booked));

        $bookingDetails = $this->booking->where('transaction_id', $transactionId)
                               ->with('users')
                               ->with(["bus" => function($bs){
                                $bs->with('cancellationslabs.cancellationSlabInfo');
                                $bs->with('BusType.busClass');
                                $bs->with('BusSitting');                
                                $bs->with('busContacts');
                                }])
                              ->with('bookingDetail')
                              ->with(['clientWallet' => function($cw){
                                $cw->orderBy('id','DESC');
                                $cw->where("status",1);
                                $cw->limit(1);
                                }])
                              ->get();

        return $bookingDetails;

       
    }

}