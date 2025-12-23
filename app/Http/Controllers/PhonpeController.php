<?php

namespace App\Http\Controllers;

use App\AppValidator\PaymentStatusValidator;
use App\Models\CustomerPayment;
use App\Models\PhonePayToken;
use App\Services\PhonpeService;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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


    public function Webhook(Request $request)
    {
        $username = 'odbusSas';
        $password = 'Admin2010';

        // echo hash('sha256', $username.':'.$password);

        // 1️⃣ Get Authorization header sent by PhonePe
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            Log::error('PhonePe Webhook: Authorization header missing');
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        // SHA256(username:password)
        $expectedHash = hash('sha256', $username . ':' . $password);

        // return $expectedHash;
        // PhonePe sends hash directly in Authorization header
        if ($authHeader !== $expectedHash) {
            Log::error('PhonePe Webhook: Invalid Authorization hash', [
                'received' => $authHeader,
                'expected' => $expectedHash
            ]);

            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // 4️⃣ Authorization verified → process payload
        $payload = $request->all();

        // Correct paths
        $state = $payload['payload']['state'] ?? null;
        $merchantOrderId = $payload['payload']['merchantOrderId'] ?? null;
        $pporderId = $payload['payload']['orderId'] ?? null;
        $amount = ($payload['payload']['amount'] ?? 0) / 100;

        // Log::info([$state, $merchantOrderId, $pporderId, $amount]);

        if ($state === 'COMPLETED') {


            $rp = $this->customerPayment->where('pp_orderId', $pporderId)->first();

            if ($rp && isset($rp->booking_id)) {
                $booking_det = $this->booking->with('users')->where('id', $rp->booking_id)->first();

                if ($booking_det->status != 1) {

                    $crt = strtotime($booking_det->created_at);
                    $now = strtotime(date("Y-m-d H:i:s"));

                    $diff = round(abs($crt - $now) / 60);


                    // if($booking_det->origin=='ODBUS'){
                    // if ($diff <= 10) {

                        $razorpay_status_updated_at = date("Y-m-d H:i:s");

                        $this->customerPayment->where('pp_orderId', $pporderId)->update(['payment_done' => 1,'phonepe_status' => $state]);

                        $this->booking->where('id', $booking_det->id)->update(['status' => 1]);
                        //// call to emailsms api function to send to customer

                        // $request['pnr']=$booking_det->pnr;
                        // $request['mobile']=$booking_det->users->phone;
                        //$res= $this->bookingManageService->emailSms($request);

                        $request['transaction_id'] = $booking_det->transaction_id;
                        $request['pp_orderId'] = $pporderId;
                        // Log::info([$request['transaction_id'],$request['pp_orderId']]);
                        $res = $this->phonpeService->paymentStatus(collect($request), 1); // 1-> super admin
                        //Log::info($booking_det->pnr."----".$res);
                        // }
                    // } else {
                    //     // Log::info("Payment receive late. So Not updateing the status: ".$booking_det->pnr."---".$response->order_id."---".$response->status."---".$response->id);
                    //     // $res = $this->channelService->NotifyToAdminForDelayPaymentFromRazorpayHook($booking_det,$response->order_id,$response->id,$response->status);

                    // }
                }
            }

            // Log::info("Payment COMPLETED for Order ID");

            return response()->json(['message' => 'payment success']);
        }
        // elseif ($state === 'FAILED') {

        //     Log::warning("Payment FAILED for Order ID: {$orderId}", [
        //         'merchantOrderId' => $merchantOrderId
        //     ]);

        //     return response()->json(['message' => 'payment failed']);

        // } else {

        //     Log::info("Payment {$state} for Order ID: {$orderId}", [
        //         'merchantOrderId' => $merchantOrderId
        //     ]);

        //     return response()->json(['message' => 'payment ignored']);
        // }

    }


    public function paymentStatus(Request $request){
        $data = CustomerPayment::where('pp_orderId',$request->pp_orderId)->first();

        return response()->json(["data" => $data]);
    }


    // public function paymentStatus(Request $request){
    //     $data = $request->all();
    //     $paymentStatusValidation = $this->paymentStatusValidator->validate($data);
        
    //     $token = JWTAuth::getToken();
    //     $user = JWTAuth::toUser($token);
    //     $clientRole = $user->role_id;
        
    //     if ($paymentStatusValidation->fails()) {
            
    //         $errors = $paymentStatusValidation->errors();
    //         return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    //     }
    //     try {
    //         // dd($request);
    //         $response = $this->phonpeService->paymentStatus($request, $clientRole);
    //         // return $response; 
    //         if ($response == 'Payment Done') {
    //             return $this->successResponse("Payment Done",Response::HTTP_OK);
    //         } else {
    //             return $this->errorResponse("Payment Failed", Response::HTTP_PAYMENT_REQUIRED);
    //         }
    //     } catch (Exception $e) {
    //         Log::info($e->getMessage());
    //         return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
    //     }
    // }
}
