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

use Razorpay\Api\Api;
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
        dd($data);
        $user = CustomerPayment::where('payment_id', $data['razorpay_order_id'])->first();

        $user->payment_done = true;
        $user->razorpay_id = $data['razorpay_payment_id'];

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        // try{
        // $attributes = array(
        //      'razorpay_signature' => $data['razorpay_signature'],
        //      'razorpay_payment_id' => $data['razorpay_payment_id'],
        //      'razorpay_order_id' => $data['razorpay_order_id']
        // );
        $razorpay_signature = $data['razorpay_signature'];
        $razorpay_payment_id = $data['razorpay_payment_id'];
        $razorpay_order_id = $data['razorpay_order_id'];

        $generated_signature = hmac_sha256($razorpay_order_id + "|" + $razorpay_payment_id, env('RAZORPAY_SECRET'));
        if ($generated_signature == $data['razorpay_signature']) {
          return 'payment is successful';
        }

        //$order = $api->utility->verifyPaymentSignature($attributes);
        //$success = true;
        // }catch(SignatureVerificationError $e){

        //     $success = false;
        // }    
        // if($success){
        //     $user->save();
        //     return $user;
        // }else{

        //     return 'error';
        // }

    }





       


}
