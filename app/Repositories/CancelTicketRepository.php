<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;
use App\Models\TicketPrice;
use App\Models\Credentials;
use App\Models\CustomerPayment;
use App\Models\CancellationSlab;
use App\Models\CancellationSlabInfo;
use App\Repositories\ChannelRepository;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Config;
use DateTime;

class CancelTicketRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $bookingDetail;
    protected $credentials;
    protected $customerPayment;
    protected $cancellationSlab;
    protected $cancellationSlabInfo;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail,ChannelRepository $channelRepository,Credentials $credentials,CustomerPayment $customerPayment,CancellationSlab $cancellationSlab,CancellationSlabInfo $cancellationSlabInfo)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
        $this->channelRepository = $channelRepository; 
        $this->credentials = $credentials;
        $this->customerPayment = $customerPayment;
        $this->cancellationSlab = $cancellationSlab;
        $this->cancellationSlabInfo = $cancellationSlabInfo;
    }   
    
    public function cancelTicket($request)
    { 
        $key = $this->credentials->first()->razorpay_key;
        $secretKey = $this->credentials->first()->razorpay_secret;

        $pnr = $request['pnr'];
        $phone = $request['phone'];
        $bookingDetails = $this->booking->with('bookingDetail')->where("pnr", $pnr)->get();
        $jDate =$bookingDetails[0]->journey_dt;
        //return $bookingDetails;
        $busId =$bookingDetails[0]->bus_id;
        $busSeatsIds = $bookingDetails[0]->bookingDetail->pluck('bus_seats_id');
        $seatsIds = $this->busSeats->whereIn('id', $busSeatsIds)->pluck('seats_id');
        $busNumber = $this->bus->where('id', $busId)->first()->bus_number;
        $sourceId =$bookingDetails[0]->source_id;
        $destinationId =$bookingDetails[0]->destination_id;
        $sourceName = $this->location->where('id', $sourceId)->first()->name;
        $destinationName = $this->location->where('id', $destinationId)->first()->name;
        $route = $sourceName .'-'. $destinationName;

        $smsData = array(
            'phone' => $phone,
            'PNR' => $pnr,
            'busdetails' => $busNumber,
            'doj' => $jDate, 
            'route' => $route,
            'seat' => $seatsIds
        );
        $boardTime =$bookingDetails[0]->boarding_time; 
        $bookingId =$bookingDetails[0]->id; 
        $booking = $this->booking->find($bookingId);

        //$transactionId =$bookingDetails[0]->transaction_id; 
        $busId =$bookingDetails[0]->bus_id; 
        $razorpay_payment_id =$this->customerPayment->where('booking_id',$bookingId)
                                                    ->first()->razorpay_id;
        $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $datetime1 = new DateTime($combinedDT);
        $datetime2 = new DateTime($current_date_time);
        $interval = $datetime1->diff($datetime2);
        // $interval = ($interval->format("%a") * 24) + $interval->format(" %h"). "h". $interval->format(" %im");
        $interval = ($interval->format("%a") * 24) + $interval->format(" %h");
        //return $interval;
        $userId = $bookingDetails[0]->users_id;
        $existPhone = $this->users->where('id',$userId)->first()->phone;
        if($existPhone == $phone){
            $slabRecords = $this->bus->where('id', $busId)                     
                    ->with('cancellationslabs.cancellationSlabInfo')
                            // ->with(["cancellationslabs.cancellationSlabInfo" => function ($query) use ($interval){
                            //     $query->whereBetween('duration',['10','20']); 
                            // }])
                    ->get();    

            $cancelPolicies = $slabRecords[0]->cancellationslabs->cancellationSlabInfo;
            foreach($cancelPolicies as $cancelPolicy){
                $duration = $cancelPolicy->duration;
                $deduction = $cancelPolicy->deduction;
                $duration = explode("-", $duration, 2);
                $max= $duration[1];
                $min= $duration[0];

                if($interval < 12) {
                    return 'Not allowed';
                    
                }elseif( $interval > 240){
                    return "240";
                    $deduction = 10;//minimum deduction
                    $refund =  $this->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking);
                    $refundAmt =  $refund['refundAmount'];
                    $smsData['refundAmount'] = $refundAmt;
                    $sendsms = $this->channelRepository->sendSmsTicketCancel($smsData);
                    return $refund;

                }elseif($min < $interval && $interval < $max){ 
                    //$refund = $this->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking)
                    ; 
                    //$refundAmt =  $refund['refundAmount'];
                    //$smsData['refundAmount'] = $refundAmt;
                    $smsData['refundAmount'] = '1000';
                
                    $sendsms = $this->channelRepository->sendSmsTicketCancel($smsData);
                    return $sendsms;
                    //return $refund;
                }
            }
        }else{
            return "invalid user";
        }
    }

    public function refundPolicy($percentage,$razorpay_payment_id,$bookingId,$booking){
        $bookingCancelled = Config::get('constants.BOOKED_CANCELLED');
        $refunded = Config::get('constants.REFUNDED');

        $key = $this->credentials->first()->razorpay_key;
        $secretKey = $this->credentials->first()->razorpay_secret;

        $api = new Api($key, $secretKey);
        $payment = $api->payment->fetch($razorpay_payment_id);
        $paidAmount = $payment->amount;
        //$percentage = $deduction;
        $refundAmount = $paidAmount * ((100-$percentage) / 100);
        //$refund = $payment->refund(array('amount' => '1')); //for partial refund
        $refund = $api->refund->create(array('payment_id' => $razorpay_payment_id, 'amount'=>           $refundAmount));
        //dd($refund);
        $refundId = $refund->id;
        $refundStatus = $refund->status;
        $refundAmount = $refund->amount;
        
        $this->booking->where('id', $bookingId)->update(array('status' => $bookingCancelled)); 
        $booking->bookingDetail()->delete();
        //$booking->delete();
        $this->customerPayment->where('razorpay_id', $razorpay_payment_id)->update(['payment_done' => $refunded,'refund_id' => $refundId]);

        $data = array(
            'refundStatus' => $refundStatus,
            'refund_id' => $refundId,
            'refundAmount' => $refundAmount   
        );
        return $data;
    }

}