<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\AgentBookingRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AgentBookingService
{
    
    protected $agentBookingRepository;    
    public function __construct(AgentBookingRepository $agentBookingRepository)
    {
        $this->agentBookingRepository = $agentBookingRepository;
    }
    public function agentBooking($request)
    {
        try {
            $bookTicket = $this->agentBookingRepository->agentBooking($request);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $bookTicket;
    }   
   
}