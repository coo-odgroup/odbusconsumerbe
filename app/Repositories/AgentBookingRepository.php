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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class AgentBookingRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $busLocationSequence;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,User $user,BusSeats $busSeats,Booking $booking,BusLocationSequence $busLocationSequence,ChannelRepository $channelRepository)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->user = $user;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->channelRepository = $channelRepository;
        $this->busLocationSequence = $busLocationSequence;       
    }   
    
    public function agentBooking($request)
    { 

        $needGstBill = Config::get('constants.NEED_GST_BILL');
        $agentInfo = $request['agentInfo'];

        $validatedAgent = $this->user->where('phone',$agentInfo['phone'])
                                     ->where('status','1')
                                     ->exists();  
        if($validatedAgent==true){
        $agentId = $this->user->where('phone',$agentInfo['phone'])
                                  ->where('status','1')
                                  ->first('id');
       
        $bookingInfo = $request['bookingInfo'];

        //Save Booking 
        $booking = new $this->booking;
        do {
           $transactionId = date('YmdHis') . gettimeofday()['usec'];
           } while ( $booking ->where('transaction_id', $transactionId )->exists());
        $booking->transaction_id =  $transactionId;
        do {
            $PNR = substr(str_shuffle("0123456789"), 0, 8);
            } while ( $booking ->where('pnr', $PNR )->exists()); 
        $booking->pnr = $PNR;
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
        $odbusGstPercent = OdbusCharges::where('bus_operator_id',$bookingInfo['bus_operator_id'])->first()->odbus_gst_charges;
        $booking->odbus_gst_charges = $odbusGstPercent;
        $odbusGstAmount = $bookingInfo['owner_fare'] * $odbusGstPercent/100;
        $booking->odbus_gst_amount = $odbusGstAmount;
        $busOperator = BusOperator::where("id",$bookingInfo['bus_operator_id'])->get();
    
        if($busOperator[0]->need_gst_bill == $needGstBill){   
            $ownerGstPercentage = $busOperator[0]->gst_amount;
            $booking->owner_gst_charges = $ownerGstPercentage;
            $ownerGstAmount = $bookingInfo['owner_fare'] * $ownerGstPercentage/100;
            $booking->owner_gst_amount = $ownerGstAmount;
        }
        $booking->created_by = $bookingInfo['created_by'];

        $agentId->booking()->save($booking);
        
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
            return "un_registered_agent";  
        }
    }
}