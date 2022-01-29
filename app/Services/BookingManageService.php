<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Users;
use App\Repositories\BookingManageRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Carbon\Carbon;
use DateTime;

class BookingManageService
{
    
    protected $bookingManageRepository;    
    public function __construct(BookingManageRepository $bookingManageRepository)
    {
        $this->bookingManageRepository = $bookingManageRepository;
    }
    public function getJourneyDetails($request)
    {
        try {          
            $pnr = $request['pnr'];
            $mobile = $request['mobile'];
    
            $journey_detail = $this->bookingManageRepository->getJourneyDetails($mobile,$pnr);
    
            if($journey_detail){            
    
                if(isset($journey_detail[0]->booking[0]) && !empty($journey_detail[0]->booking[0])){
                     $journey_detail[0]->booking['source']=$this->bookingManageRepository->GetLocationName($journey_detail[0]->booking[0]->source_id);
                     $journey_detail[0]->booking['destination']=$this->bookingManageRepository->GetLocationName($journey_detail[0]->booking[0]->source_id);
                }    
                else{                
                    return "PNR_NOT_MATCH";                
               }
           }            
           else{            
               return "MOBILE_NOT_MATCH";            
           }
    
            return $journey_detail;


        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        
    }   

    public function getPassengerDetails($request)
    {
        try {           
            $pnr = $request['pnr'];
            $mobile = $request['mobile'];
    
            $passenger_detail = $this->bookingManageRepository->getPassengerDetails($mobile,$pnr);
    
            if(isset($passenger_detail[0])){ 
                if(isset($passenger_detail[0]->booking[0]) && !empty($passenger_detail[0]->booking[0])){                  
                   return $passenger_detail;                  
                }                
                else{                
                     return "PNR_NOT_MATCH";                
                }
            }            
            else{            
                return "MOBILE_NOT_MATCH";            
            }


        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        
    }  

    public function getBookingDetails($request)
    {
        try {
            //$getBookingDetails = $this->bookingManageRepository->getBookingDetails($request);

            $pnr = $request['pnr'];
            $mobile = $request['mobile'];
    
            $booking_detail = $this->bookingManageRepository->getBookingDetails($mobile,$pnr); 
         
            if(isset($booking_detail[0])){ 
                if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){                  
                     $booking_detail[0]->booking[0]['source']=$this->bookingManageRepository->GetLocationName($booking_detail[0]->booking[0]->source_id);
                     $booking_detail[0]->booking[0]['destination']=$this->bookingManageRepository->GetLocationName($booking_detail[0]->booking[0]->destination_id);                  
                     
                    return $booking_detail;                  
                }                
                else{                
                     return "PNR_NOT_MATCH";                
                }
            }            
            else{            
                return "MOBILE_NOT_MATCH";            
            }


        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
       
    }  


    public function emailSms($request)
    {
        try {
            $pnr = $request['pnr'];
            $mobile = $request['mobile'];
           
             $b= $this->bookingManageRepository->getBookingDetails($mobile,$pnr);

             
      
            if($b && isset($b[0])){

                $b=$b[0];

                $seat_arr=[];
                $seat_no='';
            
                foreach($b->booking[0]->bookingDetail as $bd){
                    array_push($seat_arr,$bd->busSeats->seats->seatText);              
                
                }  

               $source_data= $this->bookingManageRepository->GetLocationName($b->booking[0]->source_id);
               $dest_data= $this->bookingManageRepository->GetLocationName($b->booking[0]->destination_id);

               $body = [
                    'name' => $b->name,
                    'phone' => $b->phone,
                    'email' => $b->email,
                    'pnr' => $b->booking[0]->pnr,
                    'bookingdate'=> $b->booking[0]->created_at,
                    'journeydate' => $b->booking[0]->journey_dt ,
                    'boarding_point'=> $b->booking[0]->boarding_point,
                    'dropping_point' => $b->booking[0]->dropping_point,
                    'departureTime'=> $b->booking[0]->boarding_time,
                    'arrivalTime'=> $b->booking[0]->dropping_time,
                    'seat_no' => $seat_arr,
                    'busname'=> $b->booking[0]->bus->name,
                    'source'=> $source_data[0]->name,
                    'destination'=> $dest_data[0]->name,
                    'busNumber'=> $b->booking[0]->bus->bus_number,
                    'bustype' => $b->booking[0]->bus->busType->name,
                    'busTypeName' => $b->booking[0]->bus->busType->busClass->class_name,
                    'sittingType' => $b->booking[0]->bus->busSitting->name, 
                    'conductor_number'=> $b->booking[0]->bus->busContacts->phone,
                    'passengerDetails' => $b->booking[0]->bookingDetail ,
                    'totalfare'=> $b->booking[0]->total_fare,
                    'discount'=> $b->booking[0]->coupon_discount,
                    'payable_amount'=> $b->booking[0]->payable_amount,
                    'odbus_gst'=> $b->booking[0]->odbus_gst_amount,
                    'odbus_charges'=> $b->booking[0]->odbus_charges,
                    'owner_fare'=> $b->booking[0]->owner_fare,
                    'routedetails' => $source_data[0]->name."-".$dest_data[0]->name
                    
                 
                ];
            
                if($b->email != ''){
                
                    $sendEmailTicket = $this->bookingManageRepository->sendEmailTicket($body,$b->booking[0]->pnr); 
                }

                if($b->phone != ''){
                    $sendEmailTicket = $this->bookingManageRepository->sendSmsTicket($body,$b->booking[0]->pnr); 
                }

                return "Email & SMS has been sent to ".$b->email." & ".$b->phone;

            }else{

                return "Invalid request";   

            }


        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        //return $emailSms;
    } 

    public function cancelTicketInfo($request)
    {
        try {

        $pnr = $request['pnr'];
        $mobile = $request['mobile'];

         $booking_detail  = $this->bookingManageRepository->cancelTicketInfo($mobile,$pnr);

       
      //return $booking_detail;
        if(isset($booking_detail[0])){ 
             if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){
 
                $jDate =$booking_detail[0]->booking[0]->journey_dt;
                $jDate = date("d-m-Y", strtotime($jDate));
                $boardTime =$booking_detail[0]->booking[0]->boarding_time; 

                $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                $current_date_time = Carbon::now()->toDateTimeString(); 
                $bookingDate = new DateTime($combinedDT);
                $cancelDate = new DateTime($current_date_time);
                $interval = $bookingDate->diff($cancelDate);
                 $interval = ($interval->format("%a") * 24) + $interval->format(" %h");

                 if($interval < 12) {
                    return 'CANCEL_NOT_ALLOWED';                    
                }


                $srcId = $booking_detail[0]->booking[0]->source_id;
                $desId = $booking_detail[0]->booking[0]->destination_id;
                $sourceName = Location::where('id',$srcId)->first()->name;
                $destinationName = Location::where('id',$desId)->first()->name;
                $emailData['source'] = $sourceName;
                $emailData['destination'] = $destinationName;
                $emailData['bookingDetails'] = $booking_detail;

                if($booking_detail[0]->booking[0]->status==2){
                    $emailData['cancel_status'] = false;
                }else{
                    $emailData['cancel_status'] = true;
                }

                if($booking_detail[0]->booking[0]->customerPayment != null){

                    $razorpay_payment_id=$booking_detail[0]->booking[0]->customerPayment->razorpay_id;

                    $cancelPolicies = $booking_detail[0]->booking[0]->bus->cancellationslabs->cancellationSlabInfo;
               
                
               
                    foreach($cancelPolicies as $cancelPolicy){
                       $duration = $cancelPolicy->duration;
                       $deduction = $cancelPolicy->deduction;
                       $duration = explode("-", $duration, 2);
                       $max= $duration[1];
                       $min= $duration[0];
   
       
                       if( $interval > 240){
                           $deduction = 10;//minimum deduction
                           $refund =  $this->bookingManageRepository->refundPolicy($deduction,$razorpay_payment_id);
                           $refundAmt =  ($refund['refundAmount']/100);
                           $paidAmt =  ($refund['paidAmount']/100);
   
                           $emailData['refundAmount'] = $refundAmt;
                           $emailData['deductionPercentage'] = $deduction."%";
                           $emailData['deductAmount'] =$paidAmt-$refundAmt;
                           $emailData['totalfare'] = $paidAmt;
                              
                           return $emailData;
       
                       }elseif($min <= $interval && $interval <= $max){ 
   
                           $refund =  $this->bookingManageRepository->refundPolicy($deduction,$razorpay_payment_id);
   
                           $refundAmt =  round(($refund['refundAmount']/100));
                           $paidAmt =  ($refund['paidAmount']/100);
   
                           $emailData['refundAmount'] = $refundAmt;
                           $emailData['deductionPercentage'] = $deduction."%";
                           $emailData['deductAmount'] =$paidAmt-$refundAmt;
                           $emailData['totalfare'] = $paidAmt;                          
                           return $emailData;   
                       }
                   } 
                }else{
                    $emailData['refundAmount'] = 0;
                    $emailData['deductionPercentage'] = "100%";
                    $emailData['deductAmount'] =$booking_detail[0]->booking[0]->total_fare;
                    $emailData['totalfare'] = $booking_detail[0]->booking[0]->total_fare;
                    return $emailData;
                }                          
            }    
            else{                
                return "PNR_NOT_MATCH";                
           }
       }  
       else{            
           return "MOBILE_NOT_MATCH";            
       }
        return $booking_detail;
        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        //return $cancelTicketInfo;
    } 
    
    public function agentcancelTicketOTP($request)
    {
        try {
        $pnr = $request['pnr'];
        $phone = $request['mobile'];
        $booked = Config::get('constants.BOOKED_STATUS');

        $booking_detail = $this->bookingManageRepository->agentCancelTicket($phone,$pnr,$booked); 
      //Booking exists for the PNR
        if(isset($booking_detail[0])){ 
             if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){

                $jDate =$booking_detail[0]->booking[0]->journey_dt;
                $jDate = date("d-m-Y", strtotime($jDate));
                $boardTime =$booking_detail[0]->booking[0]->boarding_time; 

                $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                $current_date_time = Carbon::now()->toDateTimeString(); 
                $bookingDate = new DateTime($combinedDT);
                $cancelDate = new DateTime($current_date_time);
                $interval = $bookingDate->diff($cancelDate);
                $interval = ($interval->format("%a") * 24) + $interval->format(" %h");

                if($interval < 12) {
                    return 'CANCEL_NOT_ALLOWED';                    
                }


                $paidAmount = $booking_detail[0]->booking[0]->total_fare; 
                $customer_comission = $booking_detail[0]->booking[0]->customer_comission; 
                


                $otp = rand(10000, 99999);
                $sendOTP = $this->bookingManageRepository->OTP($phone,$pnr,$otp,$booking_detail[0]->booking[0]->id);      
         
                $cancelPolicies = $booking_detail[0]->booking[0]->bus->cancellationslabs->cancellationSlabInfo; 
               
                foreach($cancelPolicies as $cancelPolicy){
                   $duration = $cancelPolicy->duration;
                   $deduction = $cancelPolicy->deduction;
                   $duration = explode("-", $duration, 2);
                   $max= $duration[1];
                   $min= $duration[0];

   
                   if( $interval > 240){
                       $deduction = 10;//minimum deduction
                       $refundAmt = round($paidAmount * ((100-$deduction) / 100));
                       $emailData['refundAmount'] = $refundAmt;
                       $emailData['deductionPercentage'] = $deduction."%";
                       $emailData['deductAmount'] =$paidAmount-$refundAmt;
                       $emailData['totalfare'] = $paidAmount + $customer_comission ;
                          
                       return $emailData;
   
                   }elseif($min <= $interval && $interval <= $max){ 
                        $refundAmt = round($paidAmount * ((100-$deduction) / 100));
                       $emailData['refundAmount'] = $refundAmt;
                       $emailData['deductionPercentage'] = $deduction."%";
                       $emailData['deductAmount'] =$paidAmount-$refundAmt;
                       $emailData['totalfare'] = $paidAmount + $customer_comission  ;                          
                       return $emailData;   
                   }
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

    public function agentcancelTicket($request)
    {
        try {
        $pnr = $request['pnr'];
        $phone = $request['mobile'];
        $recvOTP = $request['otp'];
        $booked = Config::get('constants.BOOKED_STATUS');

        $booking_detail  = $this->bookingManageRepository->agentCancelTicket($phone,$pnr,$booked);  
      //return $booking_detail;
        if(isset($booking_detail[0])){ 
             if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){
                $dbOTP = $booking_detail[0]->booking[0]->cancel_otp;
                if($dbOTP == $recvOTP){
                    $jDate =$booking_detail[0]->booking[0]->journey_dt;
                    $jDate = date("d-m-Y", strtotime($jDate));
                    $boardTime =$booking_detail[0]->booking[0]->boarding_time; 

                    $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                    $current_date_time = Carbon::now()->toDateTimeString(); 
                    $bookingDate = new DateTime($combinedDT);
                    $cancelDate = new DateTime($current_date_time);
                    $interval = $bookingDate->diff($cancelDate);
                    $interval = ($interval->format("%a") * 24) + $interval->format(" %h");

                    if($interval < 12) {
                        return 'CANCEL_NOT_ALLOWED';                    
                    }
                    $userId = $booking_detail[0]->booking[0]->user_id;
                    $bookingId = $booking_detail[0]->booking[0]->id;
                    $srcId = $booking_detail[0]->booking[0]->source_id;
                    $desId = $booking_detail[0]->booking[0]->destination_id;
                    $paidAmount = $booking_detail[0]->booking[0]->total_fare;
                    $sourceName = Location::where('id',$srcId)->first()->name;
                    $destinationName = Location::where('id',$desId)->first()->name;
                    $emailData['source'] = $sourceName;
                    $emailData['destination'] = $destinationName;
                    $emailData['bookingDetails'] = $booking_detail;

                    if($booking_detail[0]->booking[0]->status==2){
                        $emailData['cancel_status'] = false;
                    }else{
                        $emailData['cancel_status'] = true;
                    }

                    $cancelPolicies = $booking_detail[0]->booking[0]->bus->cancellationslabs->cancellationSlabInfo;
               
                    foreach($cancelPolicies as $cancelPolicy){
                       $duration = $cancelPolicy->duration;
                       $deduction = $cancelPolicy->deduction;
                       $duration = explode("-", $duration, 2);
                       $max= $duration[1];
                       $min= $duration[0];
   
                       if( $interval > 240){
                           $deduction = 10;//minimum deduction
                           $refundAmt = round($paidAmount * ((100-$deduction) / 100));
                           $emailData['refundAmount'] = $refundAmt;
                           $emailData['deductionPercentage'] = $deduction."%";
                           $emailData['deductAmount'] =$paidAmount-$refundAmt;
                           $emailData['totalfare'] = $paidAmount;
                           $agentWallet = $this->bookingManageRepository->updateCancelTicket($bookingId,$userId,$refundAmt, $deduction);    
                           return $emailData;
       
                       }elseif($min <= $interval && $interval <= $max){ 
                           $refundAmt = round($paidAmount * ((100-$deduction) / 100));
                           $emailData['refundAmount'] = $refundAmt;
                           $emailData['deductionPercentage'] = $deduction."%";
                           $emailData['deductAmount'] =$paidAmount-$refundAmt;
                           $emailData['totalfare'] = $paidAmount;                        
                          
                           $agentWallet = $this->bookingManageRepository->updateCancelTicket($bookingId,$userId,$refundAmt,$deduction); 
                          
                           return $emailData;   
                       }
                   } 
                }else{                
                    return "INVALID_OTP";                
                }                         
            } 
            else{                
                return "PNR_NOT_MATCH";                
           }
       } 
       else{            
           return "MOBILE_NOT_MATCH";            
       }
        return $booking_detail;

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }         
}