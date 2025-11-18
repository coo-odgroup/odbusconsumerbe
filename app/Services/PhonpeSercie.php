<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeized;
use App\Models\BusCancelled;
use App\Models\BusSeats;
use App\Models\TicketPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class PhonpeSercie
{
    protected $booking;
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }
    public function makePayment($request, $clientRole)
    {
        // return $request;exit;
        try {
            // return $request;exit;
            $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
            $busId = $request['busId'];
            $sourceId = $request['sourceId'];
            $destinationId = $request['destinationId'];
            $transactionId = $request['transaction_id'];
            $seatIds = $request['seatIds'];
            $entry_date = $request['entry_date'];
            $entry_date = date("Y-m-d", strtotime($entry_date));
            if (isset($request['IsAcBus'])) {
                $IsAcBus = $request['IsAcBus'];
            } else {
                $IsAcBus = false;
            }

            // return $sourceId;
            $records = $this->booking->with('users')->with('bookingDetail')->where('transaction_id', $transactionId)->get();
            // $records = $this->channelRepository->getBookingRecord($transationId);

            // return $records;

            $origin = $records[0]->origin;

            if ($records[0]->payable_amount == 0.00) {
                $amount = $records[0]->total_fare;
            } else {
                $amount = $records[0]->payable_amount;
            }


            if ($origin == 'ODBUS') {

                ///////////////////////cancelled bus recheck////////////////////////
                $routeDetails = TicketPrice::where('source_id', $sourceId)
                    ->where('destination_id', $destinationId)
                    ->where('bus_id', $busId)
                    ->where('status', '1')
                    ->get();


                // return $routeDetails;

                /////////////seize time recheck////////////////////////

                //$CurrentDateTime = "2022-09-09 07:46:35";
                $CurrentDateTime = Carbon::now(); //->toDateTimeString();
                if (isset($routeDetails[0])) {
                    $seizedTime = $routeDetails[0]->seize_booking_minute;
                    $depTime = date("H:i:s", strtotime($routeDetails[0]->dep_time));

                    $depDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $entry_date . ' ' . $depTime);
                    $diff_in_minutes = $depDateTime->diffInMinutes($CurrentDateTime);
                    if ($depDateTime >= $CurrentDateTime) {
                        $diff_in_minutes = $depDateTime->diffInMinutes($CurrentDateTime);
                    } else {
                        $diff_in_minutes = 0;
                    }

                    /////////////day wise seize time change////////////////////////////////
                    $dayWiseSeizeTime = BookingSeized::where('ticket_price_id', $routeDetails[0]->id)
                        ->where('seized_date', $entry_date)
                        ->where('status', 1)
                        ->get('seize_booking_minute');

                    if (!$dayWiseSeizeTime->isEmpty()) {
                        $dWiseSeizeTime = $dayWiseSeizeTime[0]->seize_booking_minute;
                        if ($dWiseSeizeTime > $diff_in_minutes) {
                            return "BUS_SEIZED";
                        }
                    } elseif ($seizedTime > $diff_in_minutes) {
                        return "BUS_SEIZED";
                    }
                }


                

                $startJDay = $routeDetails[0]->start_j_days;
                $ticketPriceId = $routeDetails[0]->id;

                switch ($startJDay) {
                    case (1):
                        $new_date = $entry_date;
                        break;
                    case (2):
                        $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
                        break;
                    case (3):
                        $new_date = date('Y-m-d', strtotime('-2 day', strtotime($entry_date)));
                        break;
                }
                
                $cancelledBus = BusCancelled::where('bus_id', $busId)
                    ->where('status', '1')
                    ->with(['busCancelledDate' => function ($bcd) use ($new_date) {
                        $bcd->where('cancelled_date', $new_date);
                    }])->get();

                $busCancel = $cancelledBus->pluck('busCancelledDate')->flatten();

                

                if (isset($busCancel) && $busCancel->isNotEmpty()) {
                    return "BUS_CANCELLED";
                }

                $seatIds = is_array($seatIds) ? $seatIds : explode(',', $seatIds);
                
                // return $amount;
                /////////////////seat block recheck////////////////////////
                $blockSeats = BusSeats::where('operation_date', $entry_date)
                    ->where('type', 2)
                    ->where('bus_id', $busId)
                    ->where('status', 1)
                    ->where('ticket_price_id', $ticketPriceId)
                    ->whereIn('seats_id', $seatIds)
                    ->get();

                if (isset($blockSeats) && $blockSeats->isNotEmpty()) {
                    return "SEAT_BLOCKED";
                }


                $data = [
                    "status" => true,
                    "message" => "READY_FOR_PAYMENT",
                    "transactionId" => $transactionId,
                    "amount" => $amount,
                    "number" => $request->mobile,
                    "user" => $records[0]->users,
                    "booking" => $records[0]
                ];


                return $data;


                // return $amount;

                // return $blockSeats;
                // $bookedHoldSeats = $this->viewSeatsService->checkBlockedSeats($request);

                // $intersect = collect($bookedHoldSeats)->intersect($seatIds);
            }

            // else if ($origin == 'DOLPHIN') {

            //     $intersect = [];

            //     $res = $this->dolphinTransformer->BlockSeat($records, $clientRole);
            //     if ($res['Status'] != 1) {
            //         return  $res['Message'];
            //     }
            // } else if ($origin == 'MANTIS') {
            //     $clientId = 1;
            //     $mantisSeatresult = $this->mantisTransformer->MantisSeatLayout($sourceId, $destinationId, $entry_date, $busId, $clientRole, $clientId);
            //     //return $mantisSeatresult;
            //     $seater = [];
            //     $lbSleeper = [];
            //     $ubSleeper = [];
            //     $sleeper = [];

            //     if (isset($mantisSeatresult['lower_berth'])) {
            //         $seater = collect($mantisSeatresult['lower_berth'])->whereIn('id', $seatIds)->where('berthType', 1)->pluck('id');

            //         $lbSleeper = collect($mantisSeatresult['lower_berth'])->whereIn('id', $seatIds)->where('berthType', 2)->pluck('id');
            //     }
            //     if (isset($mantisSeatresult['upper_berth'])) {
            //         $ubSleeper = collect($mantisSeatresult['upper_berth'])->whereIn('id', $seatIds)->where('berthType', 2)->pluck('id');
            //     }
            //     $sleeper = collect($lbSleeper)->merge(collect($ubSleeper));

            //     $data = array(
            //         'busId' => $busId,
            //         'sourceId' => $sourceId,
            //         'destinationId' => $destinationId,
            //         'seater' => $seater,
            //         'sleeper' => $sleeper,
            //         'entry_date' => $entry_date,
            //         'origin' => $origin,
            //     );
            //     $priceDetails = $this->viewSeatsService->getPriceOnSeatsSelection($data, $clientRole, $clientId);
            //     $intersect = [];

            //     $res = $this->mantisTransformer->HoldSeats($seatIds, $sourceId, $destinationId, $entry_date, $busId, $records, $clientRole, $IsAcBus);

            //     if (!$res["success"]) {
            //         return $res["Error"]["Msg"];
            //     }
            // }
            // if ($origin == 'ODBUS' || ($origin == 'DOLPHIN' && $res['Status'] == 1) || ($origin == 'MANTIS' && $res["success"])) {

            //     /////////////// calculate customer GST  (customet gst = (owner fare + service charge) - Coupon discount)

            //     $masterSetting = $this->commonRepository->getCommonSettings('1'); // 1 stands for ODBSU is from user table to get maste setting data

            //     //  if($request['customer_gst_status']==true || $request['customer_gst_status']=='true'){

            //     $update_customer_gst['customer_gst_status'] = 1;
            //     $update_customer_gst['customer_gst_number'] = $request['customer_gst_number'];
            //     $update_customer_gst['customer_gst_business_name'] = $request['customer_gst_business_name'];
            //     $update_customer_gst['customer_gst_business_email'] = $request['customer_gst_business_email'];
            //     $update_customer_gst['customer_gst_business_address'] = $request['customer_gst_business_address'];
            //     /////
            //     if ($origin == 'MANTIS') {
            //         $update_customer_gst['owner_fare'] = $priceDetails[0]['baseFare'];
            //         $update_customer_gst['customer_gst_percent'] = $masterSetting[0]->customer_gst; //as discussed with Santosh
            //         $update_customer_gst['customer_gst_amount'] = $priceDetails[0]['ownerFare'] - $priceDetails[0]['baseFare'];
            //     }
            //     /////
            //     else {
            //         $update_customer_gst['customer_gst_percent'] = $masterSetting[0]->customer_gst;

            //         $update_customer_gst['payable_amount'] = $amount;
            //     }
            //     //     }else{

            //     //         $amount = round($amount - $records[0]->customer_gst_amount,2);

            //     //         $update_customer_gst['customer_gst_status']=0;
            //     //         $update_customer_gst['customer_gst_number']=null;
            //     //         $update_customer_gst['customer_gst_business_name']=null;
            //     //         $update_customer_gst['customer_gst_business_email']=null;
            //     //         $update_customer_gst['customer_gst_business_address']=null;
            //     //         $update_customer_gst['customer_gst_percent']=0;                    
            //     //         $update_customer_gst['customer_gst_amount']=0;
            //     //         $update_customer_gst['payable_amount']=$amount;    
            //     // }

            //     $this->channelRepository->updateCustomerGST($update_customer_gst, $transationId);

            //     if ($records && $records[0]->status == $seatHold) {
            //         $key = $this->channelRepository->getRazorpayKey();

            //         $bookingId = $records[0]->id;
            //         $name = $records[0]->users->name;
            //         $email = $records[0]->users->email;
            //         $phone = $records[0]->users->phone;
            //         $receiptId = 'rcpt_' . $transationId;

            //         $GetOrderId = $this->channelRepository->UpdateCustomPayment($receiptId, $amount, $name, $email, $phone, $bookingId);

            //         $data = array(
            //             'name' => $records[0]->users->name,
            //             'amount' => $amount,
            //             'razorpay_order_id' => $GetOrderId
            //         );
            //         return $data;
            //     } elseif (count($intersect)) {
            //         return "SEAT UN-AVAIL";
            //     } else {
            //         //Update Booking Ticket Status in booking Change status to 4(Seat on hold)  
            //         $bookingId = $records[0]->id;
            //         $this->channelRepository->UpdateStatus($bookingId, $seatHold);

            //         /////mantis holdId updated to booking table////////
            //         if ($origin == 'MANTIS') {
            //             $holdId = $res["data"]['HoldId'];
            //             $this->channelRepository->UpdateMantisHoldId($transationId, $holdId);
            //         }
            //         $name = $records[0]->users->name;
            //         $email = $records[0]->users->email;
            //         $phone = $records[0]->users->phone;
            //         $receiptId = 'rcpt_' . $transationId;

            //         $key = $this->channelRepository->getRazorpayKey();

            //         $GetOrderId = $this->channelRepository->CreateCustomPayment($receiptId, $amount, $name, $email, $phone, $bookingId);

            //         $data = array(
            //             'name' => $name,
            //             'amount' => $amount,
            //             'key' => $key,
            //             'razorpay_order_id' => $GetOrderId
            //         );
            //         return $data;
            //     }
            // }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        }
    }
}
