<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AgentBookingService;
use App\AppValidator\AgentBookingValidator;

class AgentBookingController extends Controller
{

    use ApiResponser;
    
    protected $agentBookingService;
    protected $agentBookingValidator;
    

    public function __construct(AgentBookingService $agentBookingService,AgentBookingValidator $agentBookingValidator)
    {
        $this->agentBookingService = $agentBookingService;  
        $this->agentBookingValidator = $agentBookingValidator;      
    }

    public function agentBooking(Request $request) {
         $data = $request->all();
           $bookingValidation = $this->agentBookingValidator->validate($data);
   
        if ($bookingValidation->fails()) {
        $errors = $bookingValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
          try {
           $response =  $this->agentBookingService->agentBooking($request);  
          //  if($response['message']){
          //   return $this->errorResponse($response['note'],Response::HTTP_OK);
          //  }
         // else{
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
           //}
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 
}
