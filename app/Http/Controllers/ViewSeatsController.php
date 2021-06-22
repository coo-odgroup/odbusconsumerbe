<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ViewSeatsService;

class ViewSeatsController extends Controller
{

    use ApiResponser;
    
    protected $viewSeatsService;
  
    /**
     * ViewSeatsController Constructor
     *
     * @param  ViewSeatsService $ viewSeatsService, ViewSeatsValidator $ viewSeatsValidator
     *
     */
    public function __construct(ViewSeatsService $viewSeatsService)
    {
        $this->viewSeatsService = $viewSeatsService;       
    }
 
    public function getAllViewSeats(Request $request) {
        $viewSeatsData = $this->viewSeatsService->getAllViewSeats($request);
        return $this->successResponse($viewSeatsData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function getPriceOnSeatsSelection(Request $request) {

        $priceOnSeats = $this->viewSeatsService->getPriceOnSeatsSelection($request);
        return $this->successResponse($priceOnSeats,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
 
      }
      public function getBoardingDroppingPoints(Request $request) {
        $boardingPoints = $this->viewSeatsService->getBoardingDroppingPoints($request);
        return $this->successResponse($boardingPoints,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

}
