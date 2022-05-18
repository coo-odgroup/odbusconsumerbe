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
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class clientBookingController extends Controller
{

    use ApiResponser;
    
    protected $clientBookingService;
    protected $clientBookingValidator;
    

    public function __construct(ClientBookingService $clientBookingService,ClientBookingValidator $clientBookingValidator)
    {
        $this->clientBookingService = $clientBookingService;  
        $this->clientBookingValidator = $clientBookingValidator;      
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
}
