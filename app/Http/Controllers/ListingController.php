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

class ListingController extends Controller
{

    use ApiResponser;
    /**
     * @var amenitiesService
     */
    protected $listingService;
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
    public function __construct(ListingService $listingService,ListingValidator $listingValidator,FilterValidator $filterValidator,FilterOptionsValidator $filterOptionsValidator,BusDetailsValidator $busDetailsValidator,LocationValidator $locationValidator)
    {
        $this->listingService = $listingService;
        $this->listingValidator = $listingValidator; 
        $this->filterValidator = $filterValidator;
        $this->filterOptionsValidator = $filterOptionsValidator; 
        $this->busDetailsValidator = $busDetailsValidator; 
        $this->locationValidator = $locationValidator;      
    }
/**
 * @OA\Info(title="ODBUS Consumer APIs", version="0.1",
 * description="L5 Swagger OpenApi description for ODBUS Consumer APIs",
 * )
 */
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     name="Token based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="AUTH0",
 *     securityScheme="apiAuth",
 * )
 */
/**
 * @OA\Get(path="/api/getLocation",
 *   tags={"getLocation API"},
 *   summary="Get List of Locations",
 *   description="Locations with SearchValue params",
 *     @OA\Parameter(
 *          name="locationName",
 *          description="name or synonym of Location",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *  @OA\Response(response="200", description="all locations"),
 *  @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 */
    public function getLocation(Request $request) {
        $data = $request->only([
            'locationName'
        ]);
        $locationValidation = $this->locationValidator->validate($data);
        
        if ($locationValidation->fails()) {
            $errors = $locationValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }
        
        $location = $this->listingService->getLocation($request);
        return $this->successResponse($location,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/Listing",
 *     tags={"Listing API"},
 *     description="Listing",
 *     summary="Get List of Buses",
 *     @OA\Parameter(
 *          name="source",
 *          description="name of source",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destination",
 *          description="name of destination",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="entry_date",
 *          description="journey date",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="bus_operator_id",
 *          description="bus operator id",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *  @OA\Response(response="200", description="List of Buses"),
 *  @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function getAllListing(Request $request) {
        $data = $request->only([
            'source',
            'destination',
            'entry_date',
            'bus_operator_id',
          ]);
          $listingValidation = $this->listingValidator->validate($data);
          
          if ($listingValidation->fails()) {
            $errors = $listingValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
          }
          
        $listingData = $this->listingService->getAll($request);
        return $this->successResponse($listingData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

/**
 * @OA\Get(
 *     path="/api/Filter",
 *     tags={"Filter API"},
 *     description="Filter",
 *     summary="Get List of Buses with Filter Params",
 *     @OA\Parameter(
 *          name="price",
 *          description="Buses sort by price:0-without sorting, 1- ascending order sorting",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="sourceID",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destinationID",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="entry_date",
 *          description="journey date",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="bus_operator_id",
 *          description="bus operator id",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *   @OA\Parameter(
 *      name="busType[]",
 *      description="AC or NONAC type Bus:1-AC, 2-NONAC",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *        type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *    ),            
 *     @OA\Parameter(
 *          name="seatType[]",
 *          description="Seater or Sleeper type Bus:1-seater, 2&3-sleeper",
 *          in="query",
 *          required=false,
 *          @OA\Schema(
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="boardingPointId[]",
 *          description="Boarding point Ids",
 *          in="query",
 *          required=false,
 *          @OA\Schema(
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="dropingingPointId[]",
 *          description="Dropping point Ids",
 *          in="query",
 *          required=false,
 *          @OA\Schema(
 *          type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="operatorId[]",
 *          description="Operator Ids",
 *          in="query",
 *          required=false,
 *          @OA\Schema(
 *           type="array",
 *          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="amenityId[]",
 *          description="Amenity Ids",
 *          in="query",
 *          required=false,
 *          @OA\Schema(
 *          type="array",
*          @OA\Items(
 *              type="integer",
 *              format="int64",
 *              example=1,
 *              )
 *          )
 *      ),
 *  @OA\Response(response="200", description="List of Buses"),
 *  @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */ 
    public function filter(Request $request) {
        $data = $request->only([
            'price',
            'sourceID',
            'destinationID',
            'entry_date',
            'bus_operator_id',
        ]);
        $filterValidation = $this->filterValidator->validate($data);
        
        if ($filterValidation->fails()) {
            $errors = $filterValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
        $filterData = $this->listingService->filter($request);
        return $this->successResponse($filterData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/FilterOptions",
 *     tags={"FilterOptions API"},
 *     description="get all Filter options for BusType,SeatType,BoardingPoints,DroppingPoints,Operators,Amenities",
 *     summary="Get all Filter options",
 *     @OA\Parameter(
 *          name="sourceID",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destinationID",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *  @OA\Response(response="200", description="get all Filter Options"),
 *  @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function getFilterOptions(Request $request) {
        $data = $request->only([
            'sourceID',
            'destinationID'
        ]);
        $filterOptionsValidation = $this->filterOptionsValidator->validate($data);
        if ($filterOptionsValidation->fails()) {
            $errors = $filterOptionsValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
        $FilterData = $this->listingService->getFilterOptions($request);
        return $this->successResponse($FilterData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
   
    /**
 * @OA\Get(
 *     path="/api/BusDetails",
 *     tags={"BusDetails API"},
 *     description="BusDetails",
 *     summary="Get Details of a Bus",
 *     @OA\Parameter(
 *          name="bus_id",
 *          description="bus Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="source_id",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destination_id",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="200", description="Bus Details"),
 *  @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function busDetails(Request $request) {
        $data = $request->only([
            'bus_id',
            'source_id',
            'destination_id'
        ]);
        $busDetailsValidation = $this->busDetailsValidator->validate($data);
        if ($busDetailsValidation->fails()) {
            $errors = $busDetailsValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 
        $details = $this->listingService->busDetails($request);
        return $this->successResponse($details,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}
