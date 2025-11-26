<?php

namespace App\Http\Controllers;

use App\AppValidator\PaymentStatusValidator;
use App\Models\PhonePayToken;
use App\Services\PhonpeService;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PhonpeController extends Controller
{
    use ApiResponser;

    protected $phonpeService;
    protected $paymentStatusValidator;

    public function __construct(PhonpeService $phonpeService,PaymentStatusValidator $paymentStatusValidator)
    {
        $this->phonpeService = $phonpeService;
        $this->paymentStatusValidator = $paymentStatusValidator;
    }

    //     public function makePayment(Request $request)
    // {
    //     $token = JWTAuth::getToken();
    //     $user = JWTAuth::toUser($token);
    //     $clientRole = $user->role_id;

    //     try {
    //         $response = $this->phonpeService->makePayment($request, $clientRole);

    //         if ($response['status'] === true && $response['message'] === "READY_FOR_PAYMENT") {

    //             $transactionId = $response["transactionId"];
    //             $mobile = $response["number"];
    //             $amount = intval(round($response["amount"] * 100));

    //             $hardcodedToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHBpcmVzT24iOjE3NjM0NjM2NzU2NjYsIm1lcmNoYW50SWQiOiJPREJVU1VBVCJ9.1ydIU5fUpFq1B0LYpd_UbsnGQ1-d26dI7csIN7--YsU";

    //             $payload = [
    //                 "merchantId" => "ODBUSUAT",
    //                 "merchantOrderId" => $transactionId,
    //                 "amount" => $amount,
    //                 "merchantUserId" => "USER" . rand(1000, 9999),
    //                 // "redirectUrl" => "https://yourdomain.com/phonepe/callback",
    //                 "redirectMode" => "POST",
    //                 "mobileNumber" => $mobile,
    //                 "paymentInstrument" => [
    //                     "type" => "PAY_PAGE"
    //                 ]
    //             ];

    //             // return

    //             $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay";

    //             $resp = Http::withToken($hardcodedToken)
    //                 ->withHeaders(['Content-Type' => 'application/json'])
    //                 ->post($url, $payload);

    //             return response()->json($resp->json());
    //         }

    //     } catch (Exception $e) {
    //         return $this->errorResponse($e->getMessage(), \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    public function makePayment(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $token = PhonePayToken::first();

        
        // return $token;
        
        
        try {
            $response = $this->phonpeService->makePayment($request, $user->role_id);
            
            
            $orderId = data_get($response, 'pp_resp.original.orderId');
            // dd($orderId);

            // return $orderId;

            if (isset($orderId)) {

                return $this->successResponse($response, Config::get('constants.ORDERID_CREATED'), Response::HTTP_CREATED);
            } elseif ($response == 'BUS_SEIZED') {

                return $this->errorResponse(Config::get('constants.BUS_SEIZED'), Response::HTTP_OK);
            } elseif ($response == 'SEAT UN-AVAIL') {

                return $this->successResponse($response, Config::get('constants.HOLD'), Response::HTTP_OK);
            } elseif ($response == 'BUS_CANCELLED') {

                return $this->errorResponse(Config::get('constants.BUS_CANCELLED'), Response::HTTP_OK);
            } elseif ($response == 'SEAT_BLOCKED') {

                return $this->errorResponse(Config::get('constants.SEAT_BLOCKED'), Response::HTTP_OK);
            } else {
                return $this->errorResponse($response, Response::HTTP_OK);
            }
        } catch (Exception $e) {
            // dd('jsbzfhf');
            return $this->errorResponse($e->getMessage(), \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paymentStatus(Request $request){
        $data = $request->all();
        $paymentStatusValidation = $this->paymentStatusValidator->validate($data);
        
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        
        if ($paymentStatusValidation->fails()) {
            
            $errors = $paymentStatusValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }
        try {
            // dd($request);
            $response = $this->phonpeService->paymentStatus($request, $clientRole);
            // return $response; 
            if ($response == 'Payment Done') {
                return $this->successResponse("Payment Done",Response::HTTP_OK);
            } else {
                return $this->errorResponse("Payment Failed", Response::HTTP_PAYMENT_REQUIRED);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
