<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\BookTicketService;

class BookTicketController extends Controller
{

    use ApiResponser;
    /**
     * @var bookTicketService
     */
    protected $bookTicketService;
  
    /**
     * BookTicketController Constructor
     *
     * @param BookTicketService $bookTicketService
     *
     */
    public function __construct(BookTicketService $bookTicketService)
    {
        $this->bookTicketService = $bookTicketService;       
    }
 
    public function bookTicket(Request $request) {
         $data = $request->only([
            'seat_id','bookStatus','customerInfo','bookingInfo','bookingDetail'
           ]);   
          try {
           $response =  $this->bookTicketService->bookTicket($data);  
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 
}
