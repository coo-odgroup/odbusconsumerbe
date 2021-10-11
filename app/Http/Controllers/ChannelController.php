<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ChannelService;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Repositories\ChannelRepository;
use App\Models\CustomerPayment;

class ChannelController extends Controller
{
    use ApiResponser;
    protected $channelService;
    protected $channelRepository;  
    protected $customerPayment;
  
    public function __construct(ChannelService $channelService,ChannelRepository $channelRepository,CustomerPayment $customerPayment)
        {
            $this->channelService = $channelService;
            $this->channelRepository = $channelRepository;  
            $this->customerPayment = $customerPayment;
        }

    public function storeGWInfo(Request $request)
        {
          try {
           $response = $this->channelService->storeGWInfo($request); 
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
          catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }       
    }
    public function sendSms(Request $request)
    {
          try {
           $response = $this->channelService->sendSms($request); 
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }       
    }
    public function sendSmsTicket(Request $request)
    {
          try {
           $response = $this->channelService->sendSmsTicket($request); 
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }       
    }
    public function smsDeliveryStatus(Request $request)
    {
          try {
           $response = $this->channelService->smsDeliveryStatus($request); 
            return $this->successResponse($response,Config::get('constants.SMS_DELIVERED'),Response::HTTP_OK);
        }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }       
    }

    public function sendEmail(Request $request)
    {
        try {
            $response = $this->channelService->sendEmail($request); 
             return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
         }
         catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
           }   
    }

    public function sendEmailTicket(Request $request)
    {
        try {
            $response = $this->channelService->sendEmailTicket($request); 
             return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
         }
         catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
           }   
    }
    
/**
 * @OA\Post(
 *     path="/api/MakePayment",
 *     tags={"MakePayment API"},
 *     description="generating razorpay order Id",
 *     summary="generating razorpay order Id",
 *     @OA\Parameter(
 *          name="bus_id",
 *          description="BusId",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),        
 *     @OA\Parameter(
 *          name="transaction_id",
 *          description="customer transaction id against booking",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="amount",
 *          description="total price",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="201", description="Order Id generated Successfully"),
 *     @OA\Response(response="406", description="seats already booked"),
 *     @OA\Response(response="404", description="Invalid Argument Passed")
 * )
 * 
 */

      public function makePayment(Request $request)
    {   
        try {
            $response = $this->channelService->makePayment($request); 
            if($response == 'SEAT UN-AVAIL'){
                return $this->successResponse($response,Config::get('constants.HOLD'),Response::HTTP_OK);
            }
            else{
                return $this->successResponse($response,Config::get('constants.ORDERID_CREATED'),Response::HTTP_CREATED);
            }
         }
         catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
           }  
    }
/**
 * @OA\POST(
 *     path="/api/PaymentStatus",
 *     tags={"PaymentStatus API"},
 *     summary="payment status success or failure",
 *     @OA\RequestBody(
 *        required = true,
 *     description="updating payment status and sending email/sms to customers with ticket booking details",
 *        @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                property="transaction_id",
 *                type="string",
 *                example="20210722102640458159"
 *                ),
 *             @OA\Property(
 *                property="name",
 *                type="string",
 *                example="Bob"
 *                ),
 *             @OA\Property(
 *                property="phone",
 *                type="string",
 *                example=""
 *                ),
 *             @OA\Property(
 *                property="email",
 *                type="string",
 *                example="exapmle@gmail.com"
 *                ),
 *              @OA\Property(
 *                property="routedetails",
 *                type="string",
 *                example="Bhubaneswar-Sambalpur"
 *                ),
 *              @OA\Property(
 *                property="razorpay_order_id",
 *                type="string",
 *                example="order_HYnmFzO1W4mj8P"
 *                ),
 *              @OA\Property(
 *                property="razorpay_payment_id",
 *                type="string",
 *                example="pay_HYnmWNISavDZN8"
 *                ),
 *              @OA\Property(
 *                property="razorpay_signature",
 *                type="string",
 *                example="d94a898e130f431394466bd3a06ffc5f2a0471a0d4923b0b190b5576d52b6d95"
 *                ),
 *               @OA\Property(
 *                property="bookingdate",
 *                type="string",
 *                example="02-05-2021"
 *                ),
 *              @OA\Property(
 *                property="journeydate",
 *                type="string",
 *                example="08-05-2021"
 *                ),
 *            @OA\Property(
 *                property="boarding_point",
 *                type="string",
 *                example="Bermunda"
 *                ),
 *            @OA\Property(
 *                property="departureTime",
 *                type="string",
 *                example="21:00PM"
 *                ),
 *            @OA\Property(
 *                property="dropping_point",
 *                type="string",
 *                example="Hirakud"
 *                ),
 *            @OA\Property(
 *                property="arrivalTime",
 *                type="string",
 *                example="06:30AM"
 *                ),
 *            @OA\Property(
 *                property="busname",
 *                type="string",
 *                example="Jagakalia"
 *                ),
 *            @OA\Property(
 *                property="busNumber",
 *                type="string",
 *                example="OD B 8657"
 *                ),
 *            @OA\Property(
 *                property="bustype",
 *                type="string",
 *                example="AC"
 *                ),
 *            @OA\Property(
 *                property="busTypeName",
 *                type="string",
 *                example="DELUX"
 *                ),
 *            @OA\Property(
 *                property="sittingType",
 *                type="string",
 *                example="2+2"
 *                ),
 *            @OA\Property(
 *                property="conductor_number",
 *                type="string",
 *                example="9912334563"
 *                ),
 *            @OA\Property(
 *                property="totalfare",
 *                type="string",
 *                example="800"
 *                ),
 *            @OA\Property(
 *                 property="seat_id",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                  ),
 *                 ),
 *             @OA\Property(
 *                 property="seat_no",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                  ),
 *                 ),
 *             @OA\Property(
 *                property="passengerDetails",
 *                type="array",
 *                example={{
 *                  "seat_no" : "ST1",
 *                  "passenger_name": "Bob",
 *                  "passenger_gender": "M",
 *                  "passenger_age": "25"
 *                }, {
 *                  "seat_no" : "ST2",
 *                  "passenger_name": "Mom",
 *                  "passenger_gender": "F",
 *                  "passenger_age": "45"
 *                }},
 *                @OA\Items(
 *                      @OA\Property(
 *                         property="seat_no",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_name",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_gender",
 *                         type="string",
 *                         example=""
 *                      ),
 *                      @OA\Property(
 *                         property="passenger_age",
 *                         type="string",
 *                         example=""
 *                      ),
 *                ),
 *             ),
 *        ),
 *     ),
 *     @OA\Response(response="200", description="Payment successfully done"),
 *     @OA\Response(response="402", description="Payment required"),
 *     @OA\Response(response="404", description="Invalid Argument Passed")
 * )
 */
    public function pay(Request $request){
        try{
            $response = $this->channelService->pay($request); 
            If($response == 'Payment Done'){
                return $this->successResponse(Config::get('constants.PAYMENT_DONE'),Response::HTTP_OK);
            }
            else{
                return $this->errorResponse(Config::get('constants.PAYMENT_FAILED'),Response::HTTP_PAYMENT_REQUIRED);
            }  
         }
        catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
          }     
    }
  
  public function RazorpayWebhook(){
    
    
    $post = file_get_contents('php://input');

    $res = json_decode($post);
    
    
     $response=$res->payload->payment->entity; 
    

    //$myfile = fopen("razorpaywebhook.txt", "a");
   // fwrite($myfile, '\n'.$response->status."--".$response->id."--".$response->order_id."--".$response->error_description.'\n');
    //fwrite($myfile, '\n Event - '.$res->event);
    //fwrite($myfile, '\n Account ID - '.$res->account_id.'\n');
   // fclose($myfile);
    
      
    
    $razorpay_status_updated_at= date("Y-m-d H:i:s");
    
    $this->customerPayment->where('order_id', $response->order_id)
                          ->update(['razorpay_status' => $response->status,
                                    'razorpay_status_updated_at' => $razorpay_status_updated_at, 'failed_reason' => $response->error_description]); 
    
    
    
  }


}
