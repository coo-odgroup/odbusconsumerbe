<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\BookingManageRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

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
    
                if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){
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
            $emailSms = $this->bookingManageRepository->emailSms($request);

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $emailSms;
    } 

    public function cancelTicketInfo($request)
    {
        try {
            $cancelTicketInfo = $this->bookingManageRepository->cancelTicketInfo($request);

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $cancelTicketInfo;
    } 
    
    
   
}