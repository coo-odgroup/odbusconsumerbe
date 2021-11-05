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
use App\AppValidator\ViewSeatsValidator;
use App\AppValidator\PriceOnSeatSelectionValidator;
use App\AppValidator\BoardingDroppingValidator;

class ViewSeatsController extends Controller
{

    use ApiResponser;
    
    protected $viewSeatsService;
    protected $viewSeatsValidator;
    protected $priceOnSeatSelectionValidator;
    protected $boardingDroppingValidator;
  
    /**
     * ViewSeatsController Constructor
     *
     * @param  ViewSeatsService $ viewSeatsService, ViewSeatsValidator $ viewSeatsValidator
     *
     */



    public function __construct(ViewSeatsService $viewSeatsService,ViewSeatsValidator $viewSeatsValidator,PriceOnSeatSelectionValidator $priceOnSeatSelectionValidator,BoardingDroppingValidator $boardingDroppingValidator)
    {
        $this->viewSeatsService = $viewSeatsService;  
        $this->viewSeatsValidator = $viewSeatsValidator;  
        $this->priceOnSeatSelectionValidator = $priceOnSeatSelectionValidator;
        $this->boardingDroppingValidator = $boardingDroppingValidator;    
    }
 
/**
 * @OA\Get(
 *     path="/api/viewSeats",
 *     tags={"viewSeats API"},
 *     description="get all seat Information  for a Bus",
 *     summary="Get seat information for a Bus with seat layout",
 *     @OA\Parameter(
 *          name="entry_date",
 *          description="searching date",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="busId",
 *          description="bus Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="sourceId",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destinationId",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="200", description=" get all seats information"),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function getAllViewSeats(Request $request) {
        $data = $request->only([
            'busId',
            'sourceId',
            'entry_date',
            'destinationId',
        ]);
        $viewSeatsValidation = $this->viewSeatsValidator->validate($data);
        
        if ($viewSeatsValidation->fails()) {
            $errors = $viewSeatsValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }
        
        $viewSeatsData = $this->viewSeatsService->getAllViewSeats($request);
        return $this->successResponse($viewSeatsData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/PriceOnSeatsSelection",
 *     tags={"PriceOnSeatsSelection API"},
 *     description="get total price on seat selection",
 *     summary="get total price on seat selection",
 *     @OA\Parameter(
 *          name="busId",
 *          description="bus Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="sourceId",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="destinationId",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="busOperatorId",
 *          description="busOperator Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="seater[string]",
 *          description="seater Ids",
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
 *          name="sleeper[]",
 *          description="sleeper Ids",
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
 *     @OA\Response(response="200", description=" get Total Price on seats selection"),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function getPriceOnSeatsSelection(Request $request) {
        $data = $request->only([
            'busId',
            'sourceId',
            'busOperatorId',
            'destinationId',
            'seater',
            'sleeper'
        ]);
        $priveValidation = $this->priceOnSeatSelectionValidator->validate($data);
        
        if ($priveValidation->fails()) {
            $errors = $priveValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }  
        $priceOnSeats = $this->viewSeatsService->getPriceOnSeatsSelection($request);
        return $this->successResponse($priceOnSeats,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

      /**
 * @OA\Get(
 *     path="/api/BoardingDroppingPoints",
 *     tags={"BoardingDroppingPoints API"},
 *     description="get all Boarding Dropping Points for source and destination",
 *     summary="get all Boarding Dropping Points",
 *     @OA\Parameter(
 *          name="busId",
 *          description="bus Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="sourceId",
 *          description="source Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="destinationId",
 *          description="destination Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="200", description=" get all Boarding Dropping Points"),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */
    public function getBoardingDroppingPoints(Request $request) {
        $data = $request->only([
            'busId',
            'sourceId',
            'destinationId',
        ]);
        $boardDropValidation = $this->boardingDroppingValidator->validate($data);
        
        if ($boardDropValidation->fails()) {
            $errors = $boardDropValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        }  
        $boardingPoints = $this->viewSeatsService->getBoardingDroppingPoints($request);
        return $this->successResponse($boardingPoints,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}
