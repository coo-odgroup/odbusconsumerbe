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
            $bookTicket = $this->bookTicketRepository->bookTicket($request);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
        return $bookTicket;
    }   
   
}