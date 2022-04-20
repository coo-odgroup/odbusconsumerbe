<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\CancelTicketRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Arr;


class CancelTicketService
{
    
    protected $cancelTicketRepository;    
    public function __construct(CancelTicketRepository $cancelTicketRepository)
    {
        $this->cancelTicketRepository = $cancelTicketRepository;
    }
    public function cancelTicket($request)
    {
        try {          
            $pnr = $request['pnr'];
            $phone = $request['phone'];
            $booked = Config::get('constants.BOOKED_STATUS');
    
            $booking_detail  = $this->cancelTicketRepository->cancelTicket($phone,$pnr,$booked);
            if(isset($booking_detail[0])){          
    
                if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){

                    $jDate =$booking_detail[0]->booking[0]->journey_dt;
                    $jDate = date("d-m-Y", strtotime($jDate));
                    $boardTime =$booking_detail[0]->booking[0]->boarding_time;
                    $seat_arr=[];
                    foreach($booking_detail[0]->booking[0]->bookingDetail as $bd){
                        
                       $seat_arr = Arr::prepend($seat_arr, $bd->busSeats->seats->seatText);
                    }
                    $busName = $booking_detail[0]->booking[0]->bus->name;
                    $busNumber = $booking_detail[0]->booking[0]->bus->bus_number;
                    $busId = $booking_detail[0]->booking[0]->bus_id;
                    $sourceName = $this->cancelTicketRepository->GetLocationName($booking_detail[0]->booking[0]->source_id);                   
                     $destinationName =$this->cancelTicketRepository->GetLocationName($booking_detail[0]->booking[0]->destination_id);
                      $route = $sourceName .'-'. $destinationName;
                       $userMailId =$booking_detail[0]->email;
                     $bookingId =$booking_detail[0]->booking[0]->id;
                      $booking = $this->cancelTicketRepository->GetBooking($bookingId);
                    
                    
                
    
                    $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                    $current_date_time = Carbon::now()->toDateTimeString(); 
                    $bookingDate = new DateTime($combinedDT);
                    $cancelDate = new DateTime($current_date_time);
                    $interval = $bookingDate->diff($cancelDate);
                    $interval = ($interval->format("%a") * 24) + $interval->format(" %h");
                    $smsData = array(
                        'phone' => $phone,
                        'PNR' => $pnr,
                        'busdetails' => $busName.'-'.$busNumber,
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
                    if($cancelDate >= $bookingDate || $interval < 12)
                    {
                        return 'Cancellation is not allowed'; 
                    }
                    //  if($interval < 12) {
                    //     return 'Cancellation is not allowed';                    
                    // }

                    $paidAmount = $booking_detail[0]->booking[0]->total_fare;

                 if($booking_detail[0]->booking[0]->customerPayment != null){

                    $razorpay_payment_id = $booking_detail[0]->booking[0]->customerPayment->razorpay_id;   
                    $cancelPolicies = $booking_detail[0]->booking[0]->bus->cancellationslabs->cancellationSlabInfo;
                    foreach($cancelPolicies as $cancelPolicy){
                        $duration = $cancelPolicy->duration;
                        $deduction = $cancelPolicy->deduction;
                        $duration = explode("-", $duration, 2);
                        $max= $duration[1];
                        $min= $duration[0];
        
                        if( $interval > 240){
                            $deduction = 10;//minimum deduction
                            $refund =  $this->cancelTicketRepository->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking,$smsData,$emailData,$busId);
                            $refundAmt =  $refund['refundAmount'];
                            $smsData['refundAmount'] = $refundAmt;

                            $emailData['deductionPercentage'] = $deduction;
                            $emailData['refundAmount'] = $refundAmt;
                            $emailData['totalfare'] = $paidAmount;
                            
                            $sendsms = $this->cancelTicketRepository->sendSmsTicketCancel($smsData);
                            if($emailData['email'] != ''){

                                $emailData['deductionPercentage'] = $deduction;
                                $sendEmailTicketCancel = $this->cancelTicketRepository->sendEmailTicketCancel($emailData);  
                            } 
                            return $refund;
    
                        }
                        elseif($min <= $interval && $interval <= $max){ 
                            $refund = $this->cancelTicketRepository->refundPolicy($deduction,$razorpay_payment_id,$bookingId,$booking,$smsData,$emailData,$busId)
                            ; 
                            $refundAmt =  $refund['refundAmount'];
                            $smsData['refundAmount'] = $refundAmt;

                            $emailData['deductionPercentage'] = $deduction;
                            $emailData['refundAmount'] = $refundAmt;
                            $emailData['totalfare'] = $paidAmount;
                            
                            $sendsms = $this->cancelTicketRepository->sendSmsTicketCancel($smsData);
                            if($emailData['email'] != ''){
                                $sendEmailTicketCancel = $this->cancelTicketRepository->sendEmailTicketCancel($emailData);  
                            } 

                            $this->cancelTicketRepository->sendAdminEmailTicketCancel($emailData);  

                            return $refund;    
                        }
                    } 
                 } else{

                 

                    $refund = $this->cancelTicketRepository->cancel($bookingId,$booking,$smsData,$emailData,$busId)
                            ; 
                    return $refund;  

                 }  

             } 
                else{                
                     return "PNR_NOT_MATCH";                
                }
            }
            else{            
                return "MOBILE_NOT_MATCH";            
            }


        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        
    }   
   
}