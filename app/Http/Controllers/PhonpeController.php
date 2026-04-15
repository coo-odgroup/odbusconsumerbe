<?php

namespace App\Http\Controllers;

use App\AppValidator\PaymentStatusValidator;
use App\Models\Booking;
use App\Models\BusSeats;
use App\Models\CustomerPayment;
use App\Models\Location;
use App\Models\PhonePayToken;
use App\Repositories\ChannelRepository;
use App\Services\Msg91Service;
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
    protected $customerPayment;
    protected $channelRepository;
    protected $booking;
    protected $msg91Service;

    public function __construct(
        PhonpeService $phonpeService,
        PaymentStatusValidator $paymentStatusValidator,
        CustomerPayment $customerPayment,
        ChannelRepository $channelRepository,
        Booking $booking,
        Msg91Service $msg91Service
    ) {
        $this->phonpeService = $phonpeService;
        $this->paymentStatusValidator = $paymentStatusValidator;
        $this->customerPayment = $customerPayment;
        $this->channelRepository = $channelRepository;
        $this->booking = $booking;
        $this->msg91Service = $msg91Service;
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


    public function makePayment(Request $request)
    {
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

        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            Log::error('PhonePe Webhook: Authorization header missing');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $expectedHash = hash('sha256', $username . ':' . $password);

        if ($authHeader !== $expectedHash) {
            Log::error('PhonePe Webhook: Invalid Authorization hash', [
                'received' => $authHeader,
                'expected' => $expectedHash
            ]);

            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $payload = $request->all();

        $state = $payload['payload']['state'] ?? null;
        $merchantOrderId = $payload['payload']['merchantOrderId'] ?? null;
        $pporderId = $payload['payload']['orderId'] ?? null;
        $amount = ($payload['payload']['amount'] ?? 0) / 100;

        // Log::info([$payload]);

        // $pporderId = $request->pp_orderId;
        // $state = 'COMPLETED';

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

                    $this->customerPayment->where('pp_orderId', $pporderId)->update(['payment_done' => 1, 'phonepe_status' => $state]);

                    $this->booking->where('id', $booking_det->id)->update(['status' => 1]);

                    $request['transaction_id'] = $booking_det->transaction_id;
                    $request['pp_orderId'] = $pporderId;
                    // Log::info([$request['transaction_id'],$request['pp_orderId']]);
                    $res = $this->phonpeService->paymentStatus(collect($request), 1); // 1-> super admin
                }

                $transationId = Booking::where('id', $rp->booking_id)->first()->transaction_id;

                $main_source = '';
                $main_destination = '';
                $records = $this->channelRepository->getBookingRecord($transationId);

                if ($records[0]->email_sms_status == 1) {
                    return "Payment Done";
                }


                $origin = $records[0]->origin;

                if ($origin == 'ODBUS') {
                    $bookingRecord = $this->channelRepository->getBookingData($transationId);

                    $bustype = $bookingRecord[0]->bus->BusType->busClass->class_name;
                    $busTypeName = $bookingRecord[0]->bus->BusType->name;
                    $sittingType = $bookingRecord[0]->bus->BusSitting->name;
                    $conductor_number = $bookingRecord[0]->bus->busContacts->phone;

                    $busSeatsIds = $bookingRecord[0]->bookingDetail->pluck('bus_seats_id');
                    $busSeatsDetails = BusSeats::whereIn('id', $busSeatsIds)->with('seats')->get();
                    $seat_no = $busSeatsDetails->pluck('seats.seatText');
                    $busname = $bookingRecord[0]->bus->name;
                    $busId = $bookingRecord[0]->bus->id;
                    $busNumber = $bookingRecord[0]->bus->bus_number;

                    $pnr = $bookingRecord[0]->pnr;

                    $ticketPrice = DB::table('ticket_price')->where('bus_id', $bookingRecord[0]->bus_id)->where('status', '!=', 2)->first();


                    $main_source = Location::where('id', $ticketPrice->source_id)->first()->name;
                    $main_destination = Location::where('id', $ticketPrice->destination_id)->first()->name;
                }
                $passengerDetails = $bookingRecord[0]->bookingDetail;
                $bookingId = $bookingRecord[0]->id;
                $phone = $bookingRecord[0]->users->phone;
                $email = $bookingRecord[0]->users->email;
                $name = $bookingRecord[0]->users->name;
                $journeydate = $bookingRecord[0]->journey_dt;
                $fare = $bookingRecord[0]->total_fare;



                $source = Location::where('id', $bookingRecord[0]->source_id)->first()->name;
                $destination = Location::where('id', $bookingRecord[0]->destination_id)->first()->name;
                if ($main_source != '' && $main_destination != '') {
                    $routedetails = $main_source . ' To ' . $main_destination;
                } else {
                    $routedetails = $source . ' To ' . $destination;
                }

                $boarding_point = $bookingRecord[0]->boarding_point;
                $departureTime = $bookingRecord[0]->boarding_time;
                $dropping_point = $bookingRecord[0]->dropping_point;
                $arrivalTime = $bookingRecord[0]->dropping_time;
                $departureTime = date("H:i:s", strtotime($departureTime));
                $bookingdate = $bookingRecord[0]->created_at;
                $bookingdate = date("d-m-Y", strtotime($bookingdate));

                $smsData = array(
                    "pnr" => $pnr,
                    "seat_no" => $seat_no,
                    "passengerDetails" => $passengerDetails,
                    "busname" => $busname,
                    "busId" => $busId,
                    "busNumber" => $busNumber,
                    "phone" => $phone,
                    "name" => $name,
                    "email" => $email,
                    "journeydate" => $journeydate,
                    "bookingdate" => $bookingdate,
                    "boarding_point" => $boarding_point,
                    "arrivalTime" => $arrivalTime,
                    "dropping_point" => $dropping_point,
                    "routedetails" => $routedetails,
                    "departureTime" => $departureTime,
                    "conductor_number" => $conductor_number,
                    "source" => $source,
                    "destination" => $destination,
                    "bustype" => $bustype,
                    "busTypeName" => $busTypeName,
                    "sittingType" => $sittingType,
                    "fare" => $fare,
                );

                $this->msg91Service->customer_ticket_booking($smsData);
                $this->msg91Service->cmo_ticket_booking($smsData);
            }


            return response()->json(['message' => 'payment success']);
        } elseif ($state === 'FAILED') {


            $rp = $this->customerPayment->where('pp_orderId', $pporderId)->first();

            if ($rp && isset($rp->booking_id)) {
                $booking_det = $this->booking->with('users')->where('id', $rp->booking_id)->first();

                if ($booking_det->status != 1) {

                    $crt = strtotime($booking_det->created_at);
                    $now = strtotime(date("Y-m-d H:i:s"));

                    $diff = round(abs($crt - $now) / 60);

                    $this->customerPayment->where('pp_orderId', $pporderId)->update(['phonepe_status' => $state]);

                    $request['transaction_id'] = $booking_det->transaction_id;
                    $request['pp_orderId'] = $pporderId;
                    // Log::info([$request['transaction_id'],$request['pp_orderId']]);
                    // $res = $this->phonpeService->paymentStatus(collect($request), 1); // 1-> super admin
                }
            }
            return response()->json(['message' => 'payment Failed']);
        }
    }


    public function paymentStatus(Request $request)
    {
        $data = CustomerPayment::where('pp_orderId', $request->pp_orderId)->first();

        return response()->json(["data" => $data]);
    }
}
