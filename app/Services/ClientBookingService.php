<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\ClientBookingRepository;
use App\Services\ViewSeatsService;
use App\Repositories\ChannelRepository;
use App\Repositories\CancelTicketRepository;
use App\Repositories\CommonRepository;
use App\Models\TicketPrice;
use App\Models\BusCancelled;
use App\Models\Booking;
use App\Models\BusSeats;
use App\Models\Location;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ClientBookingService
{
    
    protected $clientBookingRepository;  
    protected $viewSeatsService; 
    protected $channelRepository; 
    protected $commonRepository;
    protected $cancelTicketRepository;

    public function __construct(ClientBookingRepository $clientBookingRepository,ViewSeatsService $viewSeatsService,ChannelRepository $channelRepository,CommonRepository $commonRepository,CancelTicketRepository $cancelTicketRepository)
    {
        $this->clientBookingRepository = $clientBookingRepository;
        $this->viewSeatsService = $viewSeatsService;
        $this->channelRepository = $channelRepository;
        $this->commonRepository = $commonRepository;
        $this->cancelTicketRepository = $cancelTicketRepository;
    }
    public function clientBooking($request)
    {
        try {
            $bookTicket = $this->clientBookingRepository->clientBooking($request);
            return $bookTicket;

        } catch (Exception $e) {
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
       
    }   

    public function seatBlock($request)
    {
        try {
           
                $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
                //$busId = $request['busId']; 
                //$sourceId = $request['sourceId'];
                //$destinationId = $request['destinationId'];  
                $transationId = $request['transaction_id']; 
                //$seatIds = $request['seatIds'];
                //$entry_date = $request['entry_date'];
                //$entry_date = date("Y-m-d", strtotime($entry_date));

                $bookingDetails = Booking::where('transaction_id', $transationId)
                                        ->with(["bookingDetail" => function($b){
                                            $b->with(["busSeats" => function($bs){
                                                $bs->with(["seats" => function($s){ 
                                                }]);
                                            }]);    
                                        }])
                                        ->get();
                
                $busId = $bookingDetails[0]->bus_id; 
                $sourceId = $bookingDetails[0]->source_id;
                $destinationId = $bookingDetails[0]->destination_id;
                $entry_date = $bookingDetails[0]->journey_dt;
               
                $seatIds = [];
                foreach($bookingDetails[0]->bookingDetail as $bd){
                    array_push($seatIds,$bd->busSeats->seats->id);              
                }  
                $data = array(
                    'busId' => $busId,
                    'sourceId' =>  $sourceId,
                    'destinationId' => $destinationId,
                    'entry_date' => $entry_date,
                    'seatIds' => $seatIds,
                ); 
            ///////////////////////cancelled bus recheck////////////////////////
            $routeDetails = TicketPrice::where('source_id', $sourceId)
                            ->where('destination_id', $destinationId)
                            ->where('bus_id', $busId)
                            ->where('status','1')
                            ->get(); 
                        
            $startJDay = $routeDetails[0]->start_j_days;
            $ticketPriceId = $routeDetails[0]->id;

            switch($startJDay){
                case(1):
                    $new_date = $entry_date;
                    break;
                case(2):
                    $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
                    break;
                case(3):
                    $new_date = date('Y-m-d', strtotime('-2 day', strtotime($entry_date)));
                    break;
            }   
            $cancelledBus = BusCancelled::where('bus_id', $busId)
                                        ->where('status', '1')
                                        ->with(['busCancelledDate' => function ($bcd) use ($new_date){
                                        $bcd->where('cancelled_date',$new_date);
                                        }])->get(); 
           
            $busCancel = $cancelledBus->pluck('busCancelledDate')->flatten();

            if(isset($busCancel) && $busCancel->isNotEmpty()){
                return "BUS_CANCELLED";
            }
          /////////////////seat block recheck////////////////////////
            $blockSeats = BusSeats::where('operation_date', $entry_date)
                                    ->where('type',2)
                                    ->where('bus_id',$busId)
                                    ->where('status',1)
                                    ->where('ticket_price_id',$ticketPriceId)
                                    ->whereIn('seats_id',$seatIds)
                                    ->get();                        
            if(isset($blockSeats) && $blockSeats->isNotEmpty()){
                return "SEAT_BLOCKED";
            }
        
            //$seatStatus = $this->viewSeatsService->getAllViewSeats($request);  
            $seatStatus = $this->viewSeatsService->checkSeatStatus($data);

                if(isset($seatStatus['lower_berth'])){
                    $lb = collect($seatStatus['lower_berth']);
                    $collection= $lb;
                }
                if(isset($seatStatus['upper_berth'])){
                    $ub = collect($seatStatus['upper_berth']);
                    $collection= $ub;
                }
                if(isset($lb) && isset($ub)){
                    $collection= $lb->merge($ub);
                } 
            $checkBookedSeat = $collection->whereIn('id', $seatIds)->pluck('Gender');     //Select the Gender where bus_id matches
            $filtered = $checkBookedSeat->reject(function ($value, $key) {    //remove the null value
                    return $value == null;
                });
            //return $filtered;
                $records = $this->channelRepository->getBookingRecord($transationId);

                $amount = $records[0]->total_fare;
               
                /////////////// calculate customer GST  (customet gst = (owner fare + service charge) - Coupon discount)

                $masterSetting=$this->commonRepository->getCommonSettings('1'); // 1 stands for ODBSU is from user table to get maste setting data

                if($request['customer_gst_status']==true || $request['customer_gst_status']=='true'){

                    $update_customer_gst['customer_gst_status']=1;
                    $update_customer_gst['customer_gst_number']=$request['customer_gst_number'];
                    $update_customer_gst['customer_gst_business_name']=$request['customer_gst_business_name'];
                    $update_customer_gst['customer_gst_business_email']=$request['customer_gst_business_email'];
                    $update_customer_gst['customer_gst_business_address']=$request['customer_gst_business_address'];

                    $update_customer_gst['customer_gst_percent']=$masterSetting[0]->customer_gst;

                    $customer_gst_amount= round((( ($records[0]->owner_fare+$records[0]->odbus_charges) ) *$masterSetting[0]->customer_gst)/100,2);

                    $amount = round($amount+$customer_gst_amount,2);
                    $update_customer_gst['payable_amount']=$amount;
                    
                    $update_customer_gst['customer_gst_amount']=$customer_gst_amount;

                }else{
                    $update_customer_gst['customer_gst_status']=0;
                    $update_customer_gst['customer_gst_number']=null;
                    $update_customer_gst['customer_gst_business_name']=null;
                    $update_customer_gst['customer_gst_business_email']=null;
                    $update_customer_gst['customer_gst_business_address']=null;
                    $update_customer_gst['customer_gst_percent']=0;                    
                    $update_customer_gst['customer_gst_amount']=0;
                    $update_customer_gst['payable_amount']=$amount;    
                }

                $this->channelRepository->updateCustomerGST($update_customer_gst,$transationId);

                if(sizeof($filtered->all())==0){
    
                    $bookingId = $records[0]->id;   
                    $name = $records[0]->users->name;
                    
                    //Update Booking Ticket Status in booking Change status to 4(Seat on hold)   
                    $this->channelRepository->UpdateStatus($bookingId, $seatHold);

                    $data = array(
                        'customer_name' => $name,
                        'amount' => $amount,
                    );
                    return $data;         
                }
                else{
                    return "SEAT UN-AVAIL";
                }     

        } catch (Exception $e) {
            Log::info($e);
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }   
    } 
    
    public function ticketConfirmation($request)
    {
        try {
            $bookTicket = $this->clientBookingRepository->ticketConfirmation($request);
            return $bookTicket;

        } catch (Exception $e) {
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
       
    }  
    
    public function clientCancelTicket($request)
    {
        try {        
            $pnr = $request['pnr'];
            $clientId = $request['user_id'];
            $booked = Config::get('constants.BOOKED_STATUS');

            //$booking_detail = $this->clientBookingRepository->clientCancelTicket($phone,$pnr,$booked);
            $booking_detail = $this->clientBookingRepository->clientCancelTicket($clientId,$pnr,$booked);
           
            if(isset($booking_detail[0])){ 
               
                //if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){

                       $jDate =$booking_detail[0]->journey_dt;
                       $jDate = date("d-m-Y", strtotime($jDate));
                       $boardTime =$booking_detail[0]->boarding_time; 
                       $seat_arr=[];
                       foreach($booking_detail[0]->bookingDetail as $bd){
                       
                          $seat_arr = Arr::prepend($seat_arr, $bd->busSeats->seats->seatText);
                       }
                       $busName = $booking_detail[0]->bus->name;
                       $busNumber = $booking_detail[0]->bus->bus_number;
                       $sourceName = $this->cancelTicketRepository->GetLocationName($booking_detail[0]->source_id);                   
                       $destinationName =$this->cancelTicketRepository->GetLocationName($booking_detail[0]->destination_id);
                       $route = $sourceName .'-'. $destinationName;
                       $userMailId = $booking_detail[0]->users->email;
                       $phone = $booking_detail[0]->users->phone;
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
                       return "CANCEL_NOT_ALLOWED";
                       }
                       $userId = $booking_detail[0]->user_id;
                       $bookingId = $booking_detail[0]->id;
                       $srcId = $booking_detail[0]->source_id;
                       $desId = $booking_detail[0]->destination_id;
                       //$paidAmount = $booking_detail[0]->booking[0]->payable_amount;
                       $paidAmount = $booking_detail[0]->total_fare;
                      
                       //$customer_comission = $booking_detail[0]->booking[0]->customer_comission; 
                       $sourceName = Location::where('id',$srcId)->first()->name;
                       $destinationName = Location::where('id',$desId)->first()->name;
                       
                       $data['source'] = $sourceName;
                       $data['destination'] = $destinationName;
                       $data['bookingDetails'] = $booking_detail;
   
                       if($booking_detail[0]->status==2){
                           $data['cancel_status'] = false;
                       }else{
                           $data['cancel_status'] = true;
                       }
                       
                       $cancelPolicies = $booking_detail[0]->bus->cancellationslabs->cancellationSlabInfo;
                      
                       foreach($cancelPolicies as $cancelPolicy){
                          $duration = $cancelPolicy->duration;
                          $deduction = $cancelPolicy->deduction;
                          $duration = explode("-", $duration, 2);
                          $max= $duration[1];
                          $min= $duration[0];
       
                          if( $interval > 240){
                            
                              $deduction = 10;//minimum deduction 
                              $refundAmt = round($paidAmount * ((100-$deduction) / 100),2);
                              $data['refundAmount'] = $refundAmt;
                              $data['deductionPercentage'] = $deduction."%"; 
                              $deductAmt = round($paidAmount-$refundAmt,2);
                              $data['deductAmount'] = $deductAmt;
                              $data['totalfare'] = $paidAmount;
                              //$data['totalfare'] = $paidAmount + $customer_comission;
                              $data['cancelCommission'] = $deductAmt/2;
                              
                              $clientWallet = $this->clientBookingRepository->updateClientCancelTicket($bookingId,$userId,$refundAmt,$deduction,$deductAmt); 
                             
                              $smsData['refundAmount'] = $refundAmt;     
                              $emailData['deductionPercentage'] = $deduction;
                              $emailData['refundAmount'] = $refundAmt;
                              $emailData['totalfare'] = $paidAmount;
                            
                              //$sendsms = $this->cancelTicketRepository->sendSmsTicketCancel($smsData);
                               if($emailData['email'] != ''){
                              // $sendEmailTicketCancel = $this->cancelTicketRepository->sendEmailTicketCancel($emailData);  
                               }   
                              return $data;
          
                          }elseif($min <= $interval && $interval <= $max){ 
                           
                              $refundAmt = round($paidAmount * ((100-$deduction) / 100),2);
                              $data['refundAmount'] = $refundAmt;
                              $data['deductionPercentage'] = $deduction."%";
                              $deductAmt = round($paidAmount-$refundAmt,2);
                              $data['deductAmount'] = $deductAmt;
                              $data['totalfare'] = $paidAmount;
                              $data['cancelCommission'] = $deductAmt/2;            
                            
                              $clientWallet = $this->clientBookingRepository->updateClientCancelTicket($bookingId,$userId,$refundAmt,$deduction,$deductAmt); 

                              $smsData['refundAmount'] = $refundAmt; 
                              $emailData['deductionPercentage'] = $deduction;
                              $emailData['refundAmount'] = $refundAmt;
                              $emailData['totalfare'] = $paidAmount;
                          
                              //$sendsms = $this->cancelTicketRepository->sendSmsTicketCancel($smsData);
                               if($emailData['email'] != ''){
                              //$sendEmailTicketCancel = $this->cancelTicketRepository->sendEmailTicketCancel($emailData);  
                               }    
                              return $data;   
                          }
                      }                          
              // } 
            //    else{                
            //        return "PNR_NOT_MATCH";                
            //   }
          } 
          else{            
              return "INV_CLIENT";            
          }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }    
    }   
   
   
}