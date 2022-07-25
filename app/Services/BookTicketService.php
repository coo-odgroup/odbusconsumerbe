<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\BookTicketRepository;
use App\Repositories\OfferRepository;
use App\Services\ListingService;
use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Arr;

class BookTicketService
{
    
    protected $bookTicketRepository; 
    protected $listingService; 
    public function __construct(BookTicketRepository $bookTicketRepository,OfferRepository $offerRepository,ListingService $listingService)
    {
        $this->bookTicketRepository = $bookTicketRepository;
        $this->offerRepository = $offerRepository;
        $this->listingService = $listingService;
    }
    public function bookTicket($request,$clientRole,$clientId)
    {
        try {
            
            $needGstBill = Config::get('constants.NEED_GST_BILL');
            $customerInfo = $request['customerInfo'];

            $existingUser = $this->bookTicketRepository->CheckExistingUser($customerInfo['phone']); 
                if($existingUser==true){
                    $userId = $this->bookTicketRepository->GetUserId($customerInfo['phone']);

                    $this->bookTicketRepository->UpdateInfo($userId,$customerInfo);       
                }
                else{
                    $userId = $this->bookTicketRepository->CreateUser($request['customerInfo']);   
                }
                
                $bookingInfo = $request['bookingInfo'];
                ////////////////////////busId validation////////////////////////////////////
                $sourceID = $bookingInfo['source_id'];
                $destinationID = $bookingInfo['destination_id'];
                $source = Location::where('id',$sourceID)->first()->name;
                $destination = Location::where('id',$destinationID)->first()->name;
                $reqInfo= array(
                    "source" => $source,
                    "destination" => $destination,
                    "entry_date" => $bookingInfo['journey_date'],
                    "bus_operator_id" => Null,
                    "user_id" => Null
                ); 
                $busRecords = $this->listingService->getAll($reqInfo,$clientRole,$clientId);
            
                if($busRecords){
                $busId = $bookingInfo['bus_id'];
                $busRecords->pluck('busId');
                $validBus = $busRecords->pluck('busId')->contains($busId);
                }
                    if(!$validBus){
                        return "Bus_not_running";
                    }
               
                ///////////////////////////////////////////////////////////////
                //Save Booking 
                $booking = $this->bookTicketRepository->SaveBooking($bookingInfo,$userId,$needGstBill);   
                
                /////////////auto apply coupon//////////
                $bcollection = collect($bookingInfo);
                $bcollection->put('transaction_id', $booking['transaction_id']);
                $couponDetails = Coupon::where('coupon_code',$bookingInfo['coupon_code'])
                                 ->where('bus_id',$bookingInfo['bus_id'])
                                 ->where('status','1')
                                 ->get();
                if(isset($couponDetails[0]) && ($couponDetails[0]->auto_apply==1)){
                    
                    $coupon = $this->offerRepository->coupons($bcollection);
        
                    if(collect($coupon)->has("totalAmount")){
                        return collect($booking)->merge(collect($coupon));
                    }else{
                        return collect($booking)->put('couponStatus', $coupon);
                    }     
                }       
                return $booking; 

        } catch (Exception $e) {

            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }   
   
}