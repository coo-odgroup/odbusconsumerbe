<?php

namespace App\Http\Controllers;

use App\Services\PhonpeSercie;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class PhonpeController extends Controller
{
    use ApiResponser;

    protected $phonpeSercie;
    public function __construct(PhonpeSercie $phonpeSercie)
    {
        $this->phonpeSercie = $phonpeSercie;
    }

    //     public function makePayment(Request $request)
    // {
    //     $token = JWTAuth::getToken();
    //     $user = JWTAuth::toUser($token);
    //     $clientRole = $user->role_id;

    //     try {
    //         $response = $this->phonpeSercie->makePayment($request, $clientRole);

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


    public function makePayment(Request $request)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        try {
            $response = $this->phonpeSercie->makePayment($request, $user->role_id);

            if ($response['status'] === true && $response['message'] === "READY_FOR_PAYMENT") {

                $transactionId = $response["transactionId"];
                $mobile = $response["number"];
                $amount = intval(round($response["amount"] * 100));

                $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHBpcmVzT24iOjE3NjM0NjczMDYwOTcsIm1lcmNoYW50SWQiOiJPREJVU1VBVCJ9.ud1RQyrELyW_YgkY_bPCip8tpdO1oOHn8_sKBn74Ahw";

                $payload = [
                    "merchantOrderId" => $transactionId,
                    "amount" => $amount,
                    "merchantUserId" => "USER" . rand(1000, 9999),
                    "metaInfo" => [
                        "udf1" => $mobile,
                    ],
                    "paymentFlow" => [
                        "type" => "PG_CHECKOUT",
                    ]
                ];

                $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay";

                $resp = Http::withHeaders([
                    'Authorization' => 'O-Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ])->post($url, $payload);

                return response()->json($resp->json());
            }

            return response()->json($response);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
