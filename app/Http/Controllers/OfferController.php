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
}