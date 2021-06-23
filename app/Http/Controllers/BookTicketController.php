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
use App\AppValidator\BookTicketValidator;

class BookTicketController extends Controller
{

    use ApiResponser;
    /**
     * @var bookTicketService
     */
    protected $bookTicketService;
    protected $bookTicketValidator;
    /**
     * BookTicketController Constructor
     *
     * @param BookTicketService $bookTicketService
     *
     */
    public function __construct(BookTicketService $bookTicketService,BookTicketValidator $bookTicketValidator)
    {
        $this->bookTicketService = $bookTicketService;  
        $this->bookTicketValidator = $bookTicketValidator;      
    }
 
    public function bookTicket(Request $request) {
        //  $data = $request->only([
        //     'email','phone','seat_id','bookStatus','customerInfo','bookingInfo','bookingDetail'
        //    ]);  
        //    $bookTicketValidation = $this->bookTicketValidator->validate($data);
   
        // if ($bookTicketValidation->fails()) {
        // $errors = $bookTicketValidation->errors();
        // return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        // } 
          try {
           $response =  $this->bookTicketService->bookTicket($request);  
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 
}
