<?php

namespace App\Http\Controllers;

//require('razorpay-php/Razorpay.php');
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ChannelService;
use App\Models\CustomerPayment;
Use hash_hmac;
use App\Models\Users;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Log;

class ChannelController extends Controller
{
    use ApiResponser;
    protected $channelService;
    public function __construct(ChannelService $channelService)
        {
            $this->channelService = $channelService; 
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
    
      public function makePayment(Request $request)
    {   
        try {
            $response = $this->channelService->makePayment($request); 
             return $this->successResponse($response,Config::get('constants.ORDERID_CREATED'),Response::HTTP_CREATED);
         }
         catch (Exception $e) {
             return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
           }  
    }

       public function pay(Request $request){
        $data = $request->all();
        $customerId = CustomerPayment::where('order_id', $data['razorpay_order_id'])->pluck('id');
        $customerId = $customerId[0];
        try{
        $razorpay_signature = $data['razorpay_signature'];
        $razorpay_payment_id = $data['razorpay_payment_id'];
        $razorpay_order_id = $data['razorpay_order_id'];

        $generated_signature = hash_hmac('sha256', $razorpay_order_id."|" .$razorpay_payment_id, env('RAZORPAY_SECRET'));

        if ($generated_signature == $data['razorpay_signature']) {
            
            CustomerPayment::where('id', $customerId)->update(array('razorpay_id' => $razorpay_payment_id));
            CustomerPayment::where('id', $customerId)->update(array('payment_done' => '1'));
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
