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
use App\AppValidator\AgentCancelTicketValidator;

class BookingManageController extends Controller
{

    use ApiResponser;
    /**
     * @var BookingManageService
     */
    protected $bookTicketService;
    protected $bookTicketValidator;
    protected $bookingManageService;
    protected $agentCancelTicketValidator;
    /**
     * BookingManageController Constructor
     *
     * @param BookingManageService $bookingManageService
     *
     */
    public function __construct(BookingManageService $bookingManageService,BookingManageValidator $bookingManageValidator,AgentCancelTicketValidator $agentCancelTicketValidator)
    {
        $this->bookingManageService = $bookingManageService;  
        $this->bookingManageValidator = $bookingManageValidator; 
        $this->agentCancelTicketValidator = $agentCancelTicketValidator;      
    }
    /**
     * @OA\Post(
     *     path="/api/JourneyDetails",
     *     tags={"Journey details of a costumer"},
     *     description="Journey Details",
     *     summary="Journey Details",
     *     @OA\Parameter(
     *          name="pnr",
     *          description="pnr",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="mobile",
     *          description="mobile",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="get all Journey details"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */
    public function getJourneyDetails(Request $request) {
         $data = $request->all();
           $bookingManageValidator = $this->bookingManageValidator->validate($data);
   
        if ($bookingManageValidator->fails()) {
        $errors = $bookingManageValidator->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
        try {
          $response =  $this->bookingManageService->getJourneyDetails($request);  
          if($response == 'PNR_NOT_MATCH'){
           return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
          }elseif($response == 'MOBILE_NOT_MATCH'){
           return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
          }         
          else{
           return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
          }
          
      }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }      
    } 
    /**
     * @OA\Post(
     *     path="/api/PassengerDetails",
     *     tags={"Passenger details"},
     *     description="Passenger Details",
     *     summary="Passenger Details",
     *     @OA\Parameter(
     *          name="pnr",
     *          description="pnr",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="mobile",
     *          description="mobile",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="get all Passenger details"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */
    public function getPassengerDetails(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
     try {
      $response =  $this->bookingManageService->getPassengerDetails($request);  
      if($response == 'PNR_NOT_MATCH'){
       return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
      }elseif($response == 'MOBILE_NOT_MATCH'){
       return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
      }         
      else{
       return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
      }
      
  }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
     /**
     * @OA\Post(
     *     path="/api/BookingDetails",
     *     tags={"Booking details of a customer"},
     *     description="Booking Details",
     *     summary="Booking Details",
     *     @OA\Parameter(
     *          name="pnr",
     *          description="pnr",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="mobile",
     *          description="mobile",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="get all Booking details of a customer"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */
    public function getBookingDetails(Request $request) {     

      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
         $response =  $this->bookingManageService->getBookingDetails($request);  
         if($response == 'PNR_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }elseif($response == 'MOBILE_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }         
         else{
          return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
         }
         
     }
     catch (Exception $e) {
             
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
    /**
     * @OA\Post(
     *     path="/api/EmailSms",
     *     tags={"email/sms send"},
     *     description="send email/sms",
     *     summary="send email/sms",
     *     @OA\Parameter(
     *          name="pnr",
     *          description="pnr",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="mobile",
     *          description="mobile",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="send email/sms"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */
    public function emailSms(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
         $response =  $this->bookingManageService->emailSms($request);  
         if($response=='Invalid request'){
          return $this->errorResponse($response,Response::HTTP_PARTIAL_CONTENT);
         }else{
          return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
         }
        
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
    /**
     * @OA\Post(
     *     path="/api/cancelTicketInfo",
     *     tags={"Ticket Cancel Information"},
     *     description="Ticket Cancel Information",
     *     summary="Ticket Cancel Information",
     *     @OA\Parameter(
     *          name="pnr",
     *          description="pnr",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="mobile",
     *          description="mobile",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Ticket Cancel Information"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */

    public function cancelTicketInfo(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->cancelTicketInfo($request);  

        if($response == 'PNR_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }elseif($response == 'MOBILE_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }
         elseif($response == 'CANCEL_NOT_ALLOWED'){
          return $this->errorResponse(Config::get('constants.CANCEL_NOT_ALLOWED'),Response::HTTP_PARTIAL_CONTENT);
         }         
         else{
          return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
         }

         
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
    
    public function agentcancelTicketOTP(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->bookingManageValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->agentcancelTicketOTP($request);  
       
        if($response == 'PNR_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }elseif($response == 'MOBILE_NOT_MATCH'){
          return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
         }        
         else{
          return $this->successResponse($response,Config::get('constants.OTP_SENT_CUSTOMER'),Response::HTTP_OK);
         }    
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 
    public function agentcancelTicket(Request $request) {
      $data = $request->all();
        $bookingManageValidator = $this->agentCancelTicketValidator->validate($data);

     if ($bookingManageValidator->fails()) {
     $errors = $bookingManageValidator->errors();
     return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     } 
       try {
        $response =  $this->bookingManageService->agentcancelTicket($request);  
        switch($response){
          case('PNR_NOT_MATCH'):
            return $this->errorResponse(Config::get('constants.PNR_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
            break;
          case('MOBILE_NOT_MATCH'):
            return $this->errorResponse(Config::get('constants.MOBILE_NOT_MATCH'),Response::HTTP_PARTIAL_CONTENT);
            break;
          case('CANCEL_NOT_ALLOWED'):
            return $this->errorResponse(Config::get('constants.CANCEL_NOT_ALLOWED'),Response::HTTP_PARTIAL_CONTENT);
            break;
          case('INVALID_OTP'):
            return $this->errorResponse(Config::get('constants.OTP_INVALID'),Response::HTTP_PARTIAL_CONTENT);
            break;
        }
      return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);  
     }
     catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
       }      
    } 

    
}
