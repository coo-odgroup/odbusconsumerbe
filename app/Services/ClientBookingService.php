<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\ClientBookingRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ClientBookingService
{
    
    protected $clientBookingRepository;    
    public function __construct(ClientBookingRepository $clientBookingRepository)
    {
        $this->clientBookingRepository = $clientBookingRepository;
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
   
}