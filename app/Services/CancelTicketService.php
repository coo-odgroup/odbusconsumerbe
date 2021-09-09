<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\CancelTicketRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CancelTicketService
{
    
    protected $cancelTicketRepository;    
    public function __construct(CancelTicketRepository $cancelTicketRepository)
    {
        $this->cancelTicketRepository = $cancelTicketRepository;
    }
    public function cancelTicket($request)
    {
        try {
            $cancelTicket = $this->cancelTicketRepository->cancelTicket($request);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $cancelTicket;
    }   
   
}