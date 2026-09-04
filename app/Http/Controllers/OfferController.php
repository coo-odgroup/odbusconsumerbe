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
use App\Models\Coupon;

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
        $entry_date = date('Y-m-d');

        // return $entry_date;
        $CouponDetails = Coupon::where('bus_id', $busId)
            ->where('status', 1)
            ->where('from_date', '<=', $entry_date)
            ->where('to_date', '>=', $entry_date)
            ->select(
                'id',
                'coupon_code',
                'short_desc',
                'status'
            )->get();


        return $this->successResponse($CouponDetails, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
}
