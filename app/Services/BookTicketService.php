<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\BookTicketRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Arr;

class BookTicketService
{
    
    protected $bookTicketRepository;  
    public function __construct(BookTicketRepository $bookTicketRepository)
    {
        $this->bookTicketRepository = $bookTicketRepository;
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
                return $booking; 

        } catch (Exception $e) {

            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }   
   
}