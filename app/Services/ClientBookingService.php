<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\ClientBookingRepository;
use App\Services\ViewSeatsService;
use App\Repositories\ChannelRepository;
use App\Repositories\CommonRepository;
use App\Models\TicketPrice;
use App\Models\BusCancelled;
use App\Models\Booking;
use App\Models\BusSeats;
use Exception;
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

    public function __construct(ClientBookingRepository $clientBookingRepository,ViewSeatsService $viewSeatsService,ChannelRepository $channelRepository,CommonRepository $commonRepository)
    {
        $this->clientBookingRepository = $clientBookingRepository;
        $this->viewSeatsService = $viewSeatsService;
        $this->channelRepository = $channelRepository;
        $this->commonRepository = $commonRepository;
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
                    $receiptId = 'rcpt_'.$transationId;
                    
                    //Update Booking Ticket Status in booking Change status to 4(Seat on hold)   
                    $this->channelRepository->UpdateStatus($bookingId, $seatHold);

                    $data = array(
                        'customer_name' => $name,
                        'amount' => $amount,
                    );
                    return $data;
                        
                }elseif($records && $records[0]->status == $seatHold){
                    
                    $data = array(
                        'customer_name' => $records[0]->users->name,
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
   
}