<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\BookingManageService;
use App\AppValidator\BookingManageValidator;

class BookingManageController extends Controller
{

    use ApiResponser;
    /**
     * @var BookingManageService
     */
    protected $bookTicketService;
    protected $bookTicketValidator;
    /**
     * BookingManageController Constructor
     *
     * @param BookingManageService $bookingManageService
     *
     */
    public function __construct(BookingManageService $bookingManageService,BookingManageValidator $bookingManageValidator)
    {
        $this->bookingManageService = $bookingManageService;  
        $this->bookingManageValidator = $bookingManageValidator;      
    }


    public function getJourneyDetails(Request $request) {
         $data = $request->all();
           $bookingManageValidator = $this->bookingManageValidator->validate($data);
   
        if ($bookingManageValidator->fails()) {
        $errors = $bookingManageValidator->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
          try {
           $response =  $this->bookingManageService->getJourneyDetails($request);  
            return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 

    public function getPassengerDetails(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->getPassengerDetails($request);  
         return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 

    public function getBookingDetails(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->getBookingDetails($request);  
         return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 

    public function emailSms(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->emailSms($request);  
         return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 


    public function cancelTicketInfo(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->cancelTicketInfo($request);  
         return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
    

    


    

    
}
