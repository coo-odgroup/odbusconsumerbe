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
            $getJourneyDetails = $this->bookingManageRepository->getJourneyDetails($request);

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $getJourneyDetails;
    }   

    public function getPassengerDetails($request)
    {
        try {
            $getPassengerDetails = $this->bookingManageRepository->getPassengerDetails($request);

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $getPassengerDetails;
    }  

    public function getBookingDetails($request)
    {
        try {
            $getBookingDetails = $this->bookingManageRepository->getBookingDetails($request);

        } catch (Exception $e) {
            //Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $getBookingDetails;
    }  
    
    
   
}