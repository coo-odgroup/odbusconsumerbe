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
 
/**
 * @OA\Get(
 *     path="/api/viewSeats",
 *     tags={"get all seat Information for a Bus"},
 *     description="get all seat Information  for a Bus",
 *     summary="Get seat information for a Bus with seat layout",
 *     @OA\Parameter(
 *          name="busId",
 *          description="bus Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="200", description=" get all seats information")
 * )
 * 
 */

    public function getAllViewSeats(Request $request) {
        $viewSeatsData = $this->viewSeatsService->getAllViewSeats($request);
        return $this->successResponse($viewSeatsData,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Post(
 *     path="/api/PriceOnSeatsSelection",
 *     tags={"get total price on seat selection"},
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
 *     @OA\Parameter(
 *          name="seater[]",
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
 *     @OA\Response(response="200", description=" get Total Price on seats selection")
 * )
 * 
 */
    public function getPriceOnSeatsSelection(Request $request) {

        $priceOnSeats = $this->viewSeatsService->getPriceOnSeatsSelection($request);
        return $this->successResponse($priceOnSeats,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
      }

      /**
 * @OA\Get(
 *     path="/api/BoardingDroppingPoints",
 *     tags={"get all Boarding Dropping Points"},
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
 *     @OA\Response(response="200", description=" get all Boarding Dropping Points")
 * )
 * 
 */
      public function getBoardingDroppingPoints(Request $request) {
        $boardingPoints = $this->viewSeatsService->getBoardingDroppingPoints($request);
        return $this->successResponse($boardingPoints,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

}
