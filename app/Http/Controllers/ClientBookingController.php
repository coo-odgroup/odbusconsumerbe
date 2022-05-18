<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ClientBookingService;
use App\AppValidator\ClientBookingValidator;
use App\AppValidator\SeatBlockValidator;
use App\AppValidator\TicketConfirmValidator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class clientBookingController extends Controller
{

    use ApiResponser;
    
    protected $clientBookingService;
    protected $clientBookingValidator;
    protected $seatBlockValidator;
    protected $ticketConfirmValidator;
    

    public function __construct(ClientBookingService $clientBookingService,ClientBookingValidator $clientBookingValidator,SeatBlockValidator $seatBlockValidator,TicketConfirmValidator $ticketConfirmValidator)
    {
        $this->clientBookingService = $clientBookingService;  
        $this->clientBookingValidator = $clientBookingValidator;
        $this->seatBlockValidator = $seatBlockValidator; 
        $this->ticketConfirmValidator = $ticketConfirmValidator;     
    }

    public function clientBooking(Request $request) {
        //$data = $request->all();
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $data = $request->all();
        
        $data['bookingInfo']['user_id']=$user->id;
        $data['bookingInfo']['origin']=$user->name;
        $bookingValidation = $this->clientBookingValidator->validate($data);
   
        if ($bookingValidation->fails()) {
         $errors = $bookingValidation->errors();
         return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
         try {
            $response =  $this->clientBookingService->clientBooking($data);  
            
            if(isset($response['message'])){
             return $this->errorResponse($response['note'],Response::HTTP_OK);
             }
           else{
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
           }
        }
        catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }      
    } 
    public function seatBlock(Request $request)
    {   
        $data = $request->all();
        $seatBlockValidation = $this->seatBlockValidator->validate($data);
  
        if ($seatBlockValidation->fails()) {
        $errors = $seatBlockValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
        try {
            $response = $this->clientBookingService->seatBlock($request);
            switch($response){
                case('SEAT UN-AVAIL'):  
                    return $this->successResponse($response,Config::get('constants.HOLD'),Response::HTTP_OK);
                break;
                case('BUS_CANCELLED'):    
                    return $this->errorResponse(Config::get('constants.BUS_CANCELLED'),Response::HTTP_OK);   
                break;
                case('SEAT_BLOCKED'):    
                    return $this->errorResponse(Config::get('constants.SEAT_BLOCKED'),Response::HTTP_OK);   
                break;
            }
            return $this->successResponse($response,Config::get('constants.SEAT_BLOCKED_FOR_PAYMENT'),Response::HTTP_CREATED);    
        }
        catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }        
    }
    public function ticketConfirmation(Request $request){

        $data = $request->all();
        
        $ticketConfValidation = $this->ticketConfirmValidator->validate($data);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $data = $request->all();
        
        $data['client_id']=$user->id;
        $data['client_name']=$user->name;
    
        if ($ticketConfValidation->fails()) {
        $errors = $ticketConfValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }  
        try{  
            $response = $this->clientBookingService->ticketConfirmation($data); 
            return $this->successResponse($response,Config::get('constants.TICKET_CONFIRMED'),Response::HTTP_OK);
            //  If($response == 'Payment Done'){
            //      return $this->successResponse(Config::get('constants.PAYMENT_DONE'),Response::HTTP_OK);
            //  }
            //  else{
            //     return $this->errorResponse(Config::get('constants.PAYMENT_FAILED'),Response::HTTP_PAYMENT_REQUIRED);
            // }  
         }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }     
    }
}
