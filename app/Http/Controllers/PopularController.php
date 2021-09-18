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
use App\Services\PopularService;

class PopularController extends Controller
{
    use ApiResponser;
    
    protected $popularService;
  
    public function __construct(PopularService $popularService)
    {
        $this->popularService = $popularService;       
    }
/**
 * @OA\Get(
 *     path="/api/PopularRoutes",
 *     tags={"PopularRoutes API"},
 *     description="get all Popular Routes",
 *     summary="get all Popular Routes",
 *     @OA\Response(response="200", description="get all Popular Routes")
 * )
 * 
 */
    public function getPopularRoutes(Request $request) {
        $popularRoutes = $this->popularService->getPopularRoutes($request);
        return $this->successResponse($popularRoutes,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/TopOperators",
 *     tags={"TopOperators API"},
 *     description="get all Top Operators",
 *     summary="get all Top Operators",
 *     @OA\Response(response="200", description="get all Top Operators")
 * )
 * 
 */
    public function getTopOperators(Request $request) {
        $topOperators = $this->popularService->getTopOperators($request);
        return $this->successResponse($topOperators,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/AllRoutes",
 *     tags={"All Routes API"},
 *     description="get all Routes of bus running",
 *     summary="get all Routes of bus running",
 *     @OA\Response(response="200", description="Record Fetched Successfully")
 * )
 * 
 */
    public function allRoutes(Request $request) {
        $allRoutes = $this->popularService->allRoutes($request);
        return $this->successResponse($allRoutes,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/AllOperators",
 *     tags={"All Operators API"},
 *     description="get all Operators names",
 *     summary="get all Operators names",
 *     @OA\Response(response="200", description="Record Fetched Successfully")
 * )
 * 
 */
    public function allOperators(Request $request) {
        $allRoutes = $this->popularService->allOperators($request);
        return $this->successResponse($allRoutes,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
/**
 * @OA\Get(
 *     path="/api/OperatorDetails",
 *     tags={"Operator's Details"},
 *     description="Operator's Details",
 *     summary="Operator's Details",
 *     @OA\Parameter(
 *          name="operator_id",
 *          description="operator Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\Response(response="200", description="Record Fetched Successfully")
 * )
 * 
 */
    public function operatorDetails(Request $request) {
        $allRoutes = $this->popularService->operatorDetails($request);
        return $this->successResponse($allRoutes,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}