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

class OfferController extends Controller
{

    use ApiResponser;
    
    protected $offerService;
   
    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;   
    }

    public function offers(Request $request) {
        $allOffers = $this->offerService->offers($request);
        return $this->successResponse($allOffers,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function coupons(Request $request) {
        $response = $this->offerService->coupons($request);
        switch($response){
            case('min_tran_amount'):   //Transaction amount is Less then Minimum Transation
                return $this->successResponse(Config::get('constants.COUPON_NOT_APPLICABLE'),Response::HTTP_OK);
            break;
            case('inval_coupon'):     //Invalid or Unknown Coupon ID
                return $this->successResponse(Config::get('constants.INVALID_COUPON'),Response::HTTP_OK);   
            break;
            case('coupon_expired'):   //Validity of Coupon Has Expired
                return $this->successResponse(Config::get('constants.COUPON_EXPIRED'),Response::HTTP_OK);
            break;
        
        }
        return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);    
    }
}