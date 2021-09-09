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
use Illuminate\Support\Arr;
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
        $pnr = $request['pnr'];
        $phone = $request['phone'];

        $booking_detail  = $this->users->where('phone',$phone)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr); 
            $u->with("customerPayment");           
            $u->with(["bus" => function($bs){
                $bs->with('cancellationslabs.cancellationSlabInfo');
              }]);          
            $u->with(["bookingDetail" => function($b){
                $b->with(["busSeats" => function($s){
                    $s->with("seats");
                  }]);
            }]);    
        }])->get();
        //return $booking_detail;
        if(isset($booking_detail[0])){          

            if(isset($booking_detail[0]->booking)){
 
                $jDate =$booking_detail[0]->booking->journey_dt;
                $jDate = date("d-m-Y", strtotime($jDate));
                $boardTime =$booking_detail[0]->booking->boarding_time;
                $seat_arr=[];
                foreach($booking_detail[0]->booking->bookingDetail as $bd){
                    
                   $seat_arr = Arr::prepend($seat_arr, $bd->busSeats->seats->seatText);
                }
                $busNumber = $booking_detail[0]->booking->bus->bus_number;
                $sourceName =$this->location->where('id',$booking_detail[0]->booking->source_id)->first()->name;
                $destinationName =$this->location->where('id',$booking_detail[0]->booking->destination_id)->first()->name;
                $route = $sourceName .'-'. $destinationName;
                $userMailId =$booking_detail[0]->email;
                $bookingId =$booking_detail[0]->booking->id;
                $booking = $this->booking->find($bookingId);
                $razorpay_payment_id = $booking_detail[0]->booking->customerPayment->razorpay_id;

                $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                $current_date_time = Carbon::now()->toDateTimeString(); 
                $bookingDate = new DateTime($combinedDT);
                $cancelDate = new DateTime($current_date_time);
                $interval = $bookingDate->diff($cancelDate);
                $interval = ($interval->format("%a") * 24) + $interval->format(" %h");
                $smsData = array(
                    'phone' => $phone,
                    'PNR' => $pnr,
                    'busdetails' => $busNumber,
                    'doj' => $jDate, 
                    'route' => $route,
                    'seat' => $seat_arr
                );
                $emailData = array(
                    'email' => $userMailId,
                    'contactNo' => $phone,
                    'pnr' => $pnr,
                    'journeydate' => $jDate, 
                    'route' => $route,
                    'seat_no' => $seat_arr,
                    'cancellationDateTime' => $current_date_time
                );
                 if($interval < 12) {
                    return 'Cancellation is not allowed';                    
                }
            $cancelPolicies = $booking_detail[0]->booking->bus->cancellationslabs->cancellationSlabInfo;
                foreach($cancelPolicies as $cancelPolicy){
                    $duration = $cancelPolicy->duration;
                    $deduction = $cancelPolicy->deduction;
                    $duration = explode("-", $duration, 2);
                    $max= $duration[1];
                    $min= $duration[0];
    
                    if( $interval > 240){
                        $deduction = 10;//minimum deduction
                        $refund =  $this->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking,$smsData,$emailData);
                        $refundAmt =  $refund['refundAmount'];
                        $smsData['refundAmount'] = $refundAmt;
                        
                        $sendsms = $this->channelRepository->sendSmsTicketCancel($smsData);
                        if($emailData['email'] != ''){
                            $sendEmailTicketCancel = $this->channelRepository->sendEmailTicketCancel($emailData);  
                        } 
                        return $refund;

                    }elseif($min < $interval && $interval < $max){ 
                        $refund = $this->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking,$smsData,$emailData)
                        ; 
                        //$refundAmt =  ($refund['refundAmount']/100);
                        //$paidAmt =  ($refund['paidAmount']/100);
                        //$smsData['refundAmount'] = $refundAmt;
    
                        //$emailData['refundAmount'] = $refundAmt;
                        //$emailData['deductionPercentage'] = $deduction;
                        //$emailData['totalfare'] = $paidAmt;
                        //$sendsms = $this->channelRepository->sendSmsTicketCancel($smsData);
                        // if($emailData['email'] != ''){
                        //     //$sendEmailTicketCancel = $this->channelRepository->sendEmailTicketCancel($emailData);  
                        // } 
                        return $refund;    
                    }
                }                     
            } 
            else{                
                 return "PNR is invalid";                
            }
        }
        else{            
            return "Mobile no is invalid";            
        }
    }

    public function refundPolicy($percentage,$razorpay_payment_id,$bookingId,$booking,$smsData,$emailData){

        $bookingCancelled = Config::get('constants.BOOKED_CANCELLED');
        $refunded = Config::get('constants.REFUNDED');

         $key = $this->credentials->first()->razorpay_key;
        $secretKey = $this->credentials->first()->razorpay_secret;
 
        $api = new Api($key, $secretKey);
        $payment = $api->payment->fetch($razorpay_payment_id);
        $paidAmount = $payment->amount;
        $paymentStatus = $payment->status;
        //$refundStatus = $payment['refund_status'];
        $refundStatus = $payment->refund_status;

        if($paymentStatus == 'captured'){
            if($refundStatus != null){
                return 'refunded';
            }else{
                $refundAmount = $paidAmount * ((100-$percentage) / 100);
                $refund = $api->refund->create(array('payment_id' => $razorpay_payment_id, 'amount'=> $refundAmount));
                
                $refundId = $refund->id;
                $refundStatus = $refund->status;
                $refundAmount = $refund->amount;
         
                $this->booking->where('id', $bookingId)->update(array('status' => $bookingCancelled)); 
                $booking->bookingDetail()->where('booking_id', $bookingId)->update(array('status' => $bookingCancelled));
                //$booking->bookingDetail()->delete();
                //$booking->delete();
        
                $this->customerPayment->where('razorpay_id', $razorpay_payment_id)->update(['payment_done' => $refunded,'refund_id' => $refundId]);
        
                $data = array(
                     'refundStatus' => $refundStatus,
                     'refund_id' => $refundId,
                     'refundAmount' => $refundAmount/100,
                     'paidAmount' => $paidAmount/100,
                );

                $refundAmt = $refundAmount/100;
                $smsData['refundAmount'] = $refundAmt;
               
                $sendsms = $this->channelRepository->sendSmsTicketCancel($smsData);
              
                $emailData['refundAmount'] = $refundAmt;
                $emailData['deductionPercentage'] = $percentage;
                $emailData['totalfare'] = $paidAmount;
                if($emailData['email'] != ''){
                    $sendEmailTicketCancel = $this->channelRepository->sendEmailTicketCancel($emailData);  
                } 
                return $data;
 
            }
        }else{
            return 'noPayment';
        }
    
        


        
       }
      

}