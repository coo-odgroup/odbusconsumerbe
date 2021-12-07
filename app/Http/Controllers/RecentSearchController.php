<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RecentSearchService;
use App\AppValidator\RecentSearchValidator;
use Illuminate\Support\Facades\Log;


class RecentSearchController extends Controller
{

    use ApiResponser;
    
    protected $recentSearchService;
    protected $recentSearchValidator;

   
    public function __construct(RecentSearchService $recentSearchService,RecentSearchValidator $recentSearchValidator)
    {
        $this->recentSearchService = $recentSearchService;
        $this->recentSearchValidator = $recentSearchValidator;      
    }
     /**
         * @OA\Post(
         *     path="/api/RecentSearch",
         *     tags={"Save Recent Search of a user"},
         *     description="Save Recent Search of a user",
         *     summary="Save Recent Search of a user",
         *     @OA\Parameter(
         *          name="users_id",
         *          description="users id",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="source",
         *          description="source name",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="destination",
         *          description="destination Name",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="journey_date",
         *          description="journey date",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *  @OA\Response(response="201", description="Save search details of a user"),
         *  @OA\Response(response=401, description="Unauthorized"),
         *     security={
         *       {"apiAuth": {}}
         *     }
         * )
         * 
         */    
    public function createSearch(Request $request) {
      $data = $request->all();
      
      $SearchValidator = $this->recentSearchValidator->validate($data);

      if ($SearchValidator->fails()) {
      $errors = $SearchValidator->errors();
      return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
      } 
        try {
          $response =  $this->recentSearchService->createSearch($request); 
          return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) { 
          
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }	
    } 
/**
   * @OA\Get(
   *     path="/api/RecentSearch/{userId}",
   *     tags={"Get Recent Search details of a User"},
   *     summary="Get Recent Search details of a User",
   *     @OA\Parameter(
   *         description="Get Recent Search details of a User",
   *         in="path",
   *         name="userId",
   *         required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *     ), 
   *  @OA\Response(response="200", description="Get Recent Search of a User"),
   *  @OA\Response(response="404", description="Record not Found"),
   *  @OA\Response(response=401, description="Unauthorized"),
   *     security={
   *       {"apiAuth": {}}
   *     }
   *     )
   * )
   */  
    public function getSearchDetails($userId) {
      $result = $this->recentSearchService->getSearchDetails($userId);
      return $this->successResponse($result,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);    
    }
  
}
