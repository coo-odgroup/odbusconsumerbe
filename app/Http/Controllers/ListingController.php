<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenities;
use App\Services\AmenitiesService;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ListingService;
use App\AppValidator\ListingValidator;

class ListingController extends Controller
{

    use ApiResponser;
    /**
     * @var amenitiesService
     */
    protected $listingService;
    protected $listingValidator;


    /**
     * ListingController Constructor
     *
     * @param ListingService $listingService,ListingValidator $listingValidator
     *
     */
    public function __construct(ListingService $listingService,ListingValidator $listingValidator)
    {
        $this->listingService = $listingService;
        $this->listingValidator = $listingValidator;       
    }
 
    public function getAllListing(Request $request) {
        $data = $request->only([
            'source',
            'destination',
            'entry_date',
          ]);
          $listingValidation = $this->listingValidator->validate($data);
          
          if ($listingValidation->fails()) {
            $errors = $listingValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
          }
          
        $listingData = $this->listingService->getAll($request);
        return $this->successResponse($listingData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function getLocation(Request $request) {
        $location = $this->listingService->getLocation($request);
        return $this->successResponse($location,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function filter(Request $request) {
        $filterData = $this->listingService->filter($request);
        return $this->successResponse($filterData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function getFilterOptions(Request $request) {
        $FilterData = $this->listingService->getFilterOptions($request);
        return $this->successResponse($FilterData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    
}
