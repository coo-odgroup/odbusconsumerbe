<?php

namespace App\Services;
use App\Models\CustomerNotification;
use App\Repositories\ChannelRepository;
use App\Models\CustomerPayment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Services\ViewSeatsService;
use InvalidArgumentException;

class ChannelService
{
    protected $channelRepository; 
    protected $viewSeatsService;   
    public function __construct(ChannelRepository $channelRepository,ViewSeatsService $viewSeatsService)
    {
        $this->viewSeatsService = $viewSeatsService;
        $this->channelRepository = $channelRepository;
    }
    public function storeGWInfo($data)
    {
        try {
            $gwInfo = $this->channelRepository->storeGWInfo($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $gwInfo;
    }   
    public function sendSms($data)
    {
        try {
            $sendSms = $this->channelRepository->sendSms($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendSms;
    }   
    public function sendSmsTicket($data)
    {
        try {
            $sendSmsTicket = $this->channelRepository->sendSmsTicket($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendSmsTicket;
    }   
    public function smsDeliveryStatus($data)
    {
        try {
            $deliveryStatus = $this->channelRepository->smsDeliveryStatus($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $deliveryStatus;
    }   

    public function sendEmail($data)
    {
        try {
            $sendEmail = $this->channelRepository->sendEmail($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendEmail;
    }   
    
    public function sendEmailTicket($data)
    {
        try {
            $sendEmail = $this->channelRepository->sendEmailTicket($data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $sendEmail;
    }   
    public function makePayment($request)
    {
        try {

            //$payment = $this->channelRepository->makePayment($data);
                $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
                $busId = $request['busId'];    
                $transationId = $request['transaction_id']; 
                $seatIds = $request['seatIds'];

                $seatStatus = $this->viewSeatsService->getAllViewSeats($request); 
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
                $records = $this->channelRepository->getBookingRecord($transationId);
                
                if(sizeof($filtered->all())==0){
                    //$records = $this->channelRepository->getBookingRecord($transationId);
                    $bookingId = $records[0]->id;   
                    $name = $records[0]->users->name;
                    $amount = $request['amount'];
                    $receiptId = 'rcpt_'.$transationId;
                    //$key = config('services.razorpay.key');
                    //$secretKey = config('services.razorpay.secret');

                    $key= $this->channelRepository->getRazorpayKey();
                    
                    $GetOrderId=$this->channelRepository->CreateCustomPayment($receiptId, $amount ,$name, $bookingId);
                    
                    //Update Booking Ticket Status in booking Change status to 4(Seat on hold)   
                    $this->channelRepository->UpdateStatus($bookingId, $seatHold);

                    $data = array(
                        'name' => $name,
                        'amount' => $amount,
                        'key' => $key,
                        'razorpay_order_id' => $GetOrderId   
                    );
                        return $data;
                        //return "SEAT AVAIL";
                }elseif($records && $records[0]->status == $seatHold){
                    $key= $this->channelRepository->getRazorpayKey();
                    $orderId = CustomerPayment::where('booking_id',$records[0]->id)->first()->order_id;
                    $data = array(
                        'name' => $records[0]->users->name,
                        'amount' => $request['amount'],
                        'key' => $key,
                        'razorpay_order_id' => $orderId   
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
    
    
    public function checkSeatStatus($request) // this method is for Admin API usage (adjust ticket)
    {
        try {

            //$payment = $this->channelRepository->makePayment($data);
                $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
                $busId = $request['busId'];  
                $seatIds = $request['seatIds'];

                $seatStatus = $this->viewSeatsService->getAllViewSeats($request); 
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
               
                if(sizeof($filtered->all())==0){
                return "SEAT AVAIL";
                }
                else{
                    return "SEAT UN-AVAIL";
                }

        } catch (Exception $e) {
            Log::info($e);
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
       
    } 
    
    public function pay($request)
    {
        try {
          
            $booked = Config::get('constants.BOOKED_STATUS');
            $paymentDone = Config::get('constants.PAYMENT_DONE');
            $bookedStatusFailed = Config::get('constants.BOOKED_STATUS_FAILED');
            $data = $request->all();

            $customerId = $this->channelRepository->GetCustomerPaymentId($data['razorpay_order_id']);

            $customerId = $customerId[0];
            $busId = $request['bus_id'];
            $seatIds = $request['seat_id'];
            $razorpay_signature = $data['razorpay_signature'];
            $razorpay_payment_id = $data['razorpay_payment_id'];
            $razorpay_order_id = $data['razorpay_order_id'];
            $transationId = $data['transaction_id'];
        
            $bookingRecord = $this->channelRepository->getBookingData($busId,$transationId);

            $pnr = $bookingRecord[0]->pnr;
            $bookingId = $bookingRecord[0]->id;    

            return $this->channelRepository->UpdateCutsomerPaymentInfo($razorpay_order_id,$razorpay_signature,$razorpay_payment_id,$customerId,$paymentDone
            ,$request,$bookingId,$booked,$bookedStatusFailed,$transationId,$pnr,$busId);


        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        
    }   

    public function walletPayment($request)
    {
        try {
                $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
                $busId = $request['busId'];    
                $transactionId = $request['transaction_id']; 
                $seatIds = $request['seatIds'];
                $agentId = $request['user_id'];
                $agentName = $request['user_name'];
                $appliedComission = $request['applied_comission'];
                $booked = Config::get('constants.BOOKED_STATUS');

                $seatStatus = $this->viewSeatsService->getAllViewSeats($request); 

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
                $filtered = $checkBookedSeat->reject(function ($value, $key) {                 //remove the null value
                    return $value == null;
                });
                if(sizeof($filtered->all())==0){
               
                    $records = $this->channelRepository->getBookingRecord($transactionId);
                    $bookingId = $records[0]->id;  
                    
                    $name = $records[0]->users->name;
                    $amount = $request['amount'];

                    $details=$this->channelRepository->CreateAgentPayment($agentId,$agentName,$amount ,$name, $bookingId,$transactionId);   

                    $totalSeatsBookedByAgent = $this->channelRepository->FetchAgentBookedSeats($agentId,$agentName,$seatIds,$bookingId,$booked,$appliedComission);
                    //return $totalSeatsBookedByAgent;
                    $data = array(
                        //'Comission' => $totalSeatsBookedByAgent->amount,
                        //'Total Balance' =>  $totalSeatsBookedByAgent->balance,
                        //'Agent ID' => $totalSeatsBookedByAgent->user_id,
                        'notifications' => $totalSeatsBookedByAgent->notification_heading,
                    );
                    return $data;
                    //return "SEAT AVAIL";
                }else{
                    return "SEAT UN-AVAIL";
                }

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }  
    }
    public function agentPaymentStatus($request)
    {
        try {
            $booked = Config::get('constants.BOOKED_STATUS');
            $paymentDone = Config::get('constants.PAYMENT_DONE');
            $bookedStatusFailed = Config::get('constants.BOOKED_STATUS_FAILED');
            $data = $request->all();

            $busId = $request['bus_id'];
            $seatIds = $request['seat_id'];
            $transationId = $data['transaction_id'];
            
            $bookingRecord = $this->channelRepository->getBookingData($busId,$transationId);
            $pnr = $bookingRecord[0]->pnr;
         
            $bookingId = $bookingRecord[0]->id;    
            return $this->channelRepository->UpdateAgentPaymentInfo($paymentDone,$request,$bookingId,$bookedStatusFailed,$transationId,$pnr,$booked);
            
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        
    }   

   
}