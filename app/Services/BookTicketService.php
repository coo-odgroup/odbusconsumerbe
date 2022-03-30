<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\BookTicketRepository;
use App\Repositories\OfferRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Arr;

class BookTicketService
{
    
    protected $bookTicketRepository;  
    public function __construct(BookTicketRepository $bookTicketRepository,OfferRepository $offerRepository)
    {
        $this->bookTicketRepository = $bookTicketRepository;
        $this->offerRepository = $offerRepository;
    }
    public function bookTicket($request)
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