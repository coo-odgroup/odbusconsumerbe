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
use App\AppValidator\FilterValidator;
use App\AppValidator\FilterOptionsValidator;
use App\AppValidator\BusDetailsValidator;
use App\AppValidator\LocationValidator;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\ListingRepository;

class ListingController extends Controller
{

    use ApiResponser;
    /**
     * @var amenitiesService
     */
    protected $listingService;
    protected $listingRepository;
    protected $listingValidator;
    protected $filterValidator;
    protected $filterOptionsValidator;
    protected $busDetailsValidator;
    protected $locationValidator;


    /**
     * ListingController Constructor
     *
     * @param ListingService $listingService,ListingValidator $listingValidator
     *
     */
    public function __construct(ListingRepository $listingRepository, ListingService $listingService, ListingValidator $listingValidator, FilterValidator $filterValidator, FilterOptionsValidator $filterOptionsValidator, BusDetailsValidator $busDetailsValidator, LocationValidator $locationValidator)
    {
        $this->listingService = $listingService;
        $this->listingRepository = $listingRepository;
        $this->listingValidator = $listingValidator;
        $this->filterValidator = $filterValidator;
        $this->filterOptionsValidator = $filterOptionsValidator;
        $this->busDetailsValidator = $busDetailsValidator;
        $this->locationValidator = $locationValidator;
    }

    public function getLocation(Request $request)
    {
        $data = $request->only([
            'locationName'
        ]);
        $locationValidation = $this->locationValidator->validate($data);

        if ($locationValidation->fails()) {
            $errors = $locationValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }

        $location = $this->listingService->getLocation($request);
        return $this->successResponse($location, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function getAllListing(Request $request)
    {

        $data = $request->only([
            'source',
            'destination',
            'entry_date',
            'bus_operator_id',
        ]);
        //$data = $request->all();
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;

        $listingValidation = $this->listingValidator->validate($data);

        if ($listingValidation->fails()) {
            $errors = $listingValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }

        $listingData = $this->listingService->getAll($request, $clientRole, $clientId);
        return $this->successResponse($listingData, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function busSearchListing(Request $request)
    {
        $data = $request->only([
            'source',
            'destination',
            'entry_date',
            'bus_operator_id',
        ]);
        // return $data = $request->all();
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;

        $listingValidation = $this->listingValidator->validate($data);

        if ($listingValidation->fails()) {
            $errors = $listingValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }

        $listingData = $this->listingService->getBusList($request, $clientRole, $clientId);
        return $this->successResponse($listingData, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function busFacilities($id,Request $request)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;
        $entry_date = $request->entry_date;

        return $listingData = $this->listingRepository->busFacilities($id, $entry_date);
        return $this->successResponse($listingData, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function filter(Request $request)
    {
        $data = $request->only([
            'price',
            'sourceID',
            'destinationID',
            'entry_date',
            'bus_operator_id',
        ]);
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;

        $filterValidation = $this->filterValidator->validate($data);

        if ($filterValidation->fails()) {
            $errors = $filterValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }
        $filterData = $this->listingService->filter($request, $clientRole, $clientId);
        return $this->successResponse($filterData, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function getFilterOptions(Request $request)
    {
        $data = $request->only([
            'sourceID',
            'destinationID'
        ]);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;

        $filterOptionsValidation = $this->filterOptionsValidator->validate($data);
        if ($filterOptionsValidation->fails()) {
            $errors = $filterOptionsValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }
        $FilterData = $this->listingService->getFilterOptions($request, $clientRole, $clientId);
        return $this->successResponse($FilterData, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function busDetails(Request $request)
    {
        $data = $request->only([
            'bus_id',
            'source_id',
            'destination_id',
            'journey_date'
        ]);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $clientRole = $user->role_id;
        $clientId = $user->id;

        $busDetailsValidation = $this->busDetailsValidator->validate($data);
        if ($busDetailsValidation->fails()) {
            $errors = $busDetailsValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }
        $details = $this->listingService->busDetails($request, $clientRole, $clientId);

        if ($details == 'Invalid Origin') {

            return $this->errorResponse("Invalid Origin", Response::HTTP_OK);
        }
        if ($details == 'ReferenceNumber_empty') {
            return $this->errorResponse("Reference Number is required", Response::HTTP_OK);
        } else {
            return $this->successResponse($details, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
        }
    }

    public function UpdateExternalApiLocation()
    {
        $details = $this->listingService->UpdateExternalApiLocation();
        return $this->successResponse($details, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
    public function updateMantisApiLocation()
    {
        $details = $this->listingService->updateMantisApiLocation();
        return $this->successResponse($details, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
}
