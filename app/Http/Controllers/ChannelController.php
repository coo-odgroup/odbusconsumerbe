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
use App\AppValidator\MakePaymentValidator;
use App\AppValidator\AgentWalletPaymentValidator;
use App\AppValidator\AgentPaymentStatusValidator;
use App\Jobs\TestingEmailJob;

class ChannelController extends Controller
{
    use ApiResponser;
    protected $channelService;
    protected $channelRepository;  
    protected $customerPayment;
    protected $makePaymentValidator;
    protected $agentWalletPaymentValidator;
    protected $agentPaymentStatusValidator;
  
    public function __construct(ChannelService $channelService,ChannelRepository $channelRepository,CustomerPayment $customerPayment,AgentWalletPaymentValidator $agentWalletPaymentValidator,AgentPaymentStatusValidator $agentPaymentStatusValidator,MakePaymentValidator $makePaymentValidator)
        {
            $this->channelService = $channelService;
            $this->channelRepository = $channelRepository;  
            $this->customerPayment = $agentWalletPaymentValidator;
            $this->agentWalletPaymentValidator = $agentWalletPaymentValidator;
            $this->agentPaymentStatusValidator = $agentPaymentStatusValidator;
            $this->makePaymentValidator = $makePaymentValidator;
        }

    public function testingEmail(Request $request) {

            $to = $request['email'];
            $name = $request['name'];
    
            $res= TestingEmailJob::dispatch($to, $name);

            return $this->successResponse($res,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
 
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
 *          name="busId",
 *          description="BusId",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),  
 *     @OA\Parameter(
 *          name="sourceId",
 *          description="sourceId",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ), 
 *     @OA\Parameter(
 *          name="destinationId",
 *          description="destinationId",
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
 *          name="seatIds[]",
 *          description="Seat ids",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="37",
 *              example=37,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="entry_date",
 *          description="journey date",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
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
 *     @OA\Response(response="404", description="Invalid Argument Passed"),
 *     @OA\Response(response=401, description="Unauthorized user"),
 *     security={{ "apiAuth": {} }}
 * )
 * 
 */

      public function makePayment(Request $request)
    {   
        $data = $request->all();
        $makePaymentValidation = $this->makePaymentValidator->validate($data);
  
        if ($makePaymentValidation->fails()) {
        $errors = $makePaymentValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }  
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

    public function checkSeatStatus(Request $request)
    {   
        try {
            $response = $this->channelService->checkSeatStatus($request); 
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
 *                example="20211102112722583214"
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
 *                example="Bhubaneswar-Bhadrak"
 *                ),
 *              @OA\Property(
 *                property="razorpay_order_id",
 *                type="string",
 *                example="order_IGcyPNVZ9fkc2t"
 *                ),
 *              @OA\Property(
 *                property="razorpay_payment_id",
 *                type="string",
 *                example="pay_IGcyXMFeqdRA23"
 *                ),
 *              @OA\Property(
 *                property="razorpay_signature",
 *                type="string",
 *                example="d75cef95085a484f7a40f6f5ba1dffaa4b7f06b2f2b88ee6e816c2babc1c7f12"
 *                ),
 *               @OA\Property(
 *                property="bookingdate",
 *                type="string",
 *                example="02-11-2021"
 *                ),
 *              @OA\Property(
 *                property="journeydate",
 *                type="string",
 *                example="02-11-2021"
 *                ),
 *            @OA\Property(
 *                property="boarding_point",
 *                type="string",
 *                example="Rasulgarh"
 *                ),
 *            @OA\Property(
 *                property="departureTime",
 *                type="string",
 *                example="05:00"
 *                ),
 *            @OA\Property(
 *                property="dropping_point",
 *                type="string",
 *                example="Bonth Chhawk"
 *                ),
 *            @OA\Property(
 *                property="arrivalTime",
 *                type="string",
 *                example="07:30"
 *                ),
 *            @OA\Property(
 *                property="bus_id",
 *                type="integer",
 *                example="1"
 *                ),
 *            @OA\Property(
 *                property="busname",
 *                type="string",
 *                example="Bus 2"
 *                ),
 *            @OA\Property(
 *                property="busNumber",
 *                type="string",
 *                example="OD 01 AW 1234"
 *                ),
 *            @OA\Property(
 *                property="bustype",
 *                type="string",
 *                example="NON AC"
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
 *                example="7978817539"
 *                ),
 *            @OA\Property(
 *                property="totalfare",
 *                type="string",
 *                example="285"
 *                ),
 *            @OA\Property(
 *                 property="seat_id",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                 example="26",
 *                  ),
 *                 ),
 *             @OA\Property(
 *                 property="seat_no",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                 example="sl6",
 *                  ),
 *                 ),
 *            @OA\Property(
 *                property="discount",
 *                type="string",
 *                example="0"
 *                ),
 *            @OA\Property(
 *                property="payable_amount",
 *                type="string",
 *                example="285"
 *                ),
 *            @OA\Property(
 *                property="odbus_charges",
 *                type="string",
 *                example="0"
 *                ),
 *            @OA\Property(
 *                property="odbus_gst",
 *                type="string",
 *                example="25"
 *                ),
 *            @OA\Property(
 *                property="owner_fare",
 *                type="string",
 *                example="250"
 *                ),
 *            @OA\Property(
 *                property="source",
 *                type="string",
 *                example="Bhubaneswar"
 *                ),
 *            @OA\Property(
 *                property="destination",
 *                type="string",
 *                example="Bhadrak"
 *                ),
 *             @OA\Property(
 *                property="passengerDetails",
 *                type="array",
 *                example={{
 *                  "bus_seats_id" : "14",
 *                  "passenger_name": "Bob",
 *                  "passenger_gender": "M",
 *                  "passenger_age": "25",
 *                  "created_by": "customer"
 *                }, {
 *                  "bus_seats_id" : "15",
 *                  "passenger_name": "Mom",
 *                  "passenger_gender": "F",
 *                  "passenger_age": "45",
  *                  "created_by": "customer"
 *                }},
 *                @OA\Items(
 *                      @OA\Property(
 *                         property="bus_seats_id",
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
 *                      @OA\Property(
 *                         property="created_by",
 *                         type="string",
 *                         example=""
 *                      ),
 *                ),
 *             ),
 *        ),
 *     ),
 *     @OA\Response(response="200", description="Payment successfully done"),
 *     @OA\Response(response="402", description="Payment required"),
 *     @OA\Response(response="404", description="Invalid Argument Passed"),
 *     @OA\Response(response=401, description="Unauthorized user"),
 *     security={{ "apiAuth": {} }}
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
/**
 * @OA\Post(
 *     path="/api/AgentWalletPayment",
 *     tags={"AgentWalletPayment API"},
 *     description="Agent Wallet Payment to book tickets for customer",
 *     summary="Agent Wallet Payment to book tickets for customer",
 *     @OA\Parameter(
 *          name="user_id",
 *          description="user id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ), 
 *     @OA\Parameter(
 *          name="busId",
 *          description="BusId",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),  
 *     @OA\Parameter(
 *          name="sourceId",
 *          description="sourceId",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ), 
 *     @OA\Parameter(
 *          name="destinationId",
 *          description="destinationId",
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
 *          name="seatIds[]",
 *          description="Seat ids",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="37",
 *              example=37,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="entry_date",
 *          description="journey date",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
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
 *     @OA\Response(response="201", description="Wallet Payment Successful"),
 *     @OA\Response(response="406", description="seats already booked"),
 *     @OA\Response(response="404", description="Invalid Argument Passed"),
 *     @OA\Response(response=401, description="Unauthorized user"),
 *     security={{ "apiAuth": {} }}
 * )
 * 
 */

  public function walletPayment(Request $request)
  {   
      $data = $request->all();
      $walletPaymentValidation = $this->agentWalletPaymentValidator->validate($data);

      if ($walletPaymentValidation->fails()) {
      $errors = $walletPaymentValidation->errors();
      return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
      }  
      try {
          $response = $this->channelService->walletPayment($request); 
          if($response == 'SEAT UN-AVAIL'){
              return $this->successResponse($response,Config::get('constants.HOLD'),Response::HTTP_OK);
          }
          else{
              return $this->successResponse($response,Config::get('constants.WALLET_PAYMENT_SUCESS'),Response::HTTP_CREATED);
          }
       }
       catch (Exception $e) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
         }  
  }
  /**
 * @OA\POST(
 *     path="/api/AgentPaymentStatus",
 *     tags={"AgentPaymentStatus API"},
 *     summary="payment status success or failure",
 *     @OA\RequestBody(
 *        required = true,
 *     description="updating payment status and sending email/sms to customers with ticket booking details",
 *        @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                property="transaction_id",
 *                type="string",
 *                example="20211102112722583214"
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
 *                example="Bhubaneswar-Bhadrak"
 *                ),
 *              @OA\Property(
 *                property="razorpay_order_id",
 *                type="string",
 *                example="order_IGcyPNVZ9fkc2t"
 *                ),
 *              @OA\Property(
 *                property="razorpay_payment_id",
 *                type="string",
 *                example="pay_IGcyXMFeqdRA23"
 *                ),
 *              @OA\Property(
 *                property="razorpay_signature",
 *                type="string",
 *                example="d75cef95085a484f7a40f6f5ba1dffaa4b7f06b2f2b88ee6e816c2babc1c7f12"
 *                ),
 *               @OA\Property(
 *                property="bookingdate",
 *                type="string",
 *                example="02-11-2021"
 *                ),
 *              @OA\Property(
 *                property="journeydate",
 *                type="string",
 *                example="02-11-2021"
 *                ),
 *            @OA\Property(
 *                property="boarding_point",
 *                type="string",
 *                example="Rasulgarh"
 *                ),
 *            @OA\Property(
 *                property="departureTime",
 *                type="string",
 *                example="05:00"
 *                ),
 *            @OA\Property(
 *                property="dropping_point",
 *                type="string",
 *                example="Bonth Chhawk"
 *                ),
 *            @OA\Property(
 *                property="arrivalTime",
 *                type="string",
 *                example="07:30"
 *                ),
 *            @OA\Property(
 *                property="busname",
 *                type="string",
 *                example="Bus 2"
 *                ),
 *            @OA\Property(
 *                property="busNumber",
 *                type="string",
 *                example="OD 01 AW 1234"
 *                ),
 *            @OA\Property(
 *                property="bustype",
 *                type="string",
 *                example="NON AC"
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
 *                example="7978817539"
 *                ),
 *            @OA\Property(
 *                property="totalfare",
 *                type="string",
 *                example="285"
 *                ),
 *            @OA\Property(
 *                 property="seat_id",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                 example="26",
 *                  ),
 *                 ),
 *             @OA\Property(
 *                 property="seat_no",
 *                 type="array",
 *                 @OA\Items(type="string",
 *                 example="sl6",
 *                  ),
 *                 ),
 *            @OA\Property(
 *                property="discount",
 *                type="string",
 *                example="0"
 *                ),
 *            @OA\Property(
 *                property="payable_amount",
 *                type="string",
 *                example="285"
 *                ),
 *            @OA\Property(
 *                property="odbus_charges",
 *                type="string",
 *                example="0"
 *                ),
 *            @OA\Property(
 *                property="odbus_gst",
 *                type="string",
 *                example="25"
 *                ),
 *            @OA\Property(
 *                property="owner_fare",
 *                type="string",
 *                example="250"
 *                ),
 *            @OA\Property(
 *                property="source",
 *                type="string",
 *                example="Bhubaneswar"
 *                ),
 *            @OA\Property(
 *                property="destination",
 *                type="string",
 *                example="Bhadrak"
 *                ),
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
 *     @OA\Response(response="404", description="Invalid Argument Passed"),
 *     @OA\Response(response=401, description="Unauthorized user"),
 *     security={{ "apiAuth": {} }}
 * )
 */

  public function agentPaymentStatus(Request $request){

    $data = $request->all();
    $paymentStatusValidation = $this->agentPaymentStatusValidator->validate($data);

    if ($paymentStatusValidation->fails()) {
    $errors = $paymentStatusValidation->errors();
    return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
    }  
    try{  
        $response = $this->channelService->agentPaymentStatus($request); 
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
}
