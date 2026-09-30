<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\OfferService;
use App\AppValidator\CouponValidator;
use App\Models\Booking;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{

    use ApiResponser;

    protected $offerService;
    protected $couponValidator;

    public function __construct(OfferService $offerService, CouponValidator $couponValidator)
    {
        $this->offerService = $offerService;
        $this->couponValidator = $couponValidator;
    }



    public function offers(Request $request)
    {
        $allOffers = $this->offerService->offers($request);
        return $this->successResponse($allOffers, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }


    public function listingOffers(Request $request)
    {
        // return "fdklsnkjbsfkjfdsjn";
        $allOffers = $this->offerService->listingOffers($request);
        return $this->successResponse($allOffers, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function coupons(Request $request)
    {

        $data = $request->all();
        $couponValidation = $this->couponValidator->validate($data);

        if ($couponValidation->fails()) {
            $errors = $couponValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }
        try {
            $response = $this->offerService->coupons($request);
            switch ($response) {
                case ('min_tran_amount'):   //Transaction amount is Less then Minimum Transation
                    return $this->errorResponse(Config::get('constants.COUPON_NOT_APPLICABLE'), Response::HTTP_OK);
                    break;
                case ('inval_coupon'):     //Invalid or Unknown Coupon code
                    return $this->errorResponse(Config::get('constants.INVALID_COUPON'), Response::HTTP_OK);
                    break;
                case ('coupon_expired'):   //Validity of Coupon Has Expired
                    return $this->errorResponse(Config::get('constants.COUPON_EXPIRED'), Response::HTTP_OK);
                    break;
                case ('already_applied'):   //Validity of Coupon Has already applied once
                    return $this->errorResponse(Config::get('constants.COUPON_ALREADY_APPLIED_ONCE'), Response::HTTP_OK);
                    break;

                case ('not_firsttime_user'):   //Validity of Coupon Has already applied once
                    return $this->errorResponse('This Coupon is only applicable for first time user', Response::HTTP_OK);
                    break;
            }
            return $this->successResponse($response, Config::get('constants.COUPON_APPLIED'), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
        }
    }


    public function getPathUrls(Request $request)
    {
        $allUrls = $this->offerService->getPathUrls($request);
        return $this->successResponse($allUrls, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }


    public function couponCode(Request $request)
    {
        $busId = $request->bus_id;

        $bookingDate = date('Y-m-d');
        $journeyDate = Carbon::createFromFormat(
            'd-m-Y',
            $request->date
        )->format('Y-m-d');

        $CouponDetails = Coupon::where(function ($q) use ($busId) {

            // Coupon for specific bus
            $q->where('bus_id', $busId)

                // OR coupon applicable for all routes/buses
                ->orWhere(function ($q2) {
                    $q2->whereNull('bus_id')
                        ->where('all_route_check', 1);
                });
        })
            ->where('status', 1)
            ->where(function ($query) use ($bookingDate, $journeyDate) {

                // Valid based on booking date
                $query->where(function ($q) use ($bookingDate) {
                    $q->where('valid_by', 2)
                        ->whereDate('from_date', '<=', $bookingDate)
                        ->whereDate('to_date', '>=', $bookingDate);
                })

                    // Valid based on journey date
                    ->orWhere(function ($q) use ($journeyDate) {
                        $q->where('valid_by', 1)
                            ->whereDate('from_date', '<=', $journeyDate)
                            ->whereDate('to_date', '>=', $journeyDate);
                    });
            })
            ->select(
                'id',
                'coupon_code',
                'short_desc',
                'full_desc',
                'status',
                'valid_by',
                'bus_id',
                'all_route_check'
            )
            ->distinct()
            ->get();

        return $this->successResponse(
            $CouponDetails,
            Config::get('constants.RECORD_FETCHED'),
            Response::HTTP_OK
        );
    }

    public function removeCoupons(Request $request)
    {
        $booking = Booking::where('transaction_id', $request->transaction_id)->first();

        if (!$booking) {
            return $this->successResponse(
                Config::get('constants.RECORD_FETCHED'),
                Response::HTTP_OK
            );
        }

        if ($booking->coupon_code !== null) {
            DB::table('booking')->where('transaction_id', $request->transaction_id)->where('users_id', $booking->users_id)
                ->update([
                    'coupon_code'     => null,
                    'coupon_discount' => 0,
                    'payable_amount'  => $booking->total_fare,
                ]);
        }

        return $this->successResponse(
            [],
            Config::get('constants.RECORD_UPDATED'),
            Response::HTTP_OK
        );
    }
}
