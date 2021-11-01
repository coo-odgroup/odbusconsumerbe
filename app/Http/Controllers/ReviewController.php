<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ReviewService;
use App\AppValidator\ReviewValidator;
use Illuminate\Support\Facades\Log;


class ReviewController extends Controller
{

    use ApiResponser;
     /**
     * @var reviewService
     */
    protected $reviewService;
    protected $reviewValidator;

    /**
     * PostController Constructor
     *
     * @param ReviewService $reviewService
     *
     */
    public function __construct(ReviewService $reviewService,ReviewValidator $reviewValidator)
    {
        $this->reviewService = $reviewService;
        $this->reviewValidator = $reviewValidator;      
    }
    /**
     * @OA\Get(
     *     path="/api/allReviews",
     *     tags={"All Reviews"},
     *     description="get all Reviews of a customer",
     *     summary="get all Reviews of a customer",
     *     @OA\Response(response="200", description="get all Reviews of a customer"),
     *     @OA\Response(response=401, description="Unauthorized user"),
     *     security={{ "apiAuth": {} }}
     * )
     * 
     */
    public function getAllReview() {
      $result = $this->reviewService->getAllReview();
      return $this->successResponse($result,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);    
    }
        /**
         * @OA\Post(
         *     path="/api/AddReview",
         *     tags={"Add Review by a customer"},
         *     description="Add Review of a customer",
         *     summary="Add Review of a customer",
         *     @OA\Parameter(
         *          name="pnr",
         *          description="pnr",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
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
         *          name="users_id",
         *          description="users id",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="reference_key",
         *          description="reference key",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="rating_overall",
         *          description="rating overall",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="number"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="rating_comfort",
         *          description="rating comfort",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="number"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="rating_clean",
         *          description="rating_clean",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="number"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="rating_behavior",
         *          description="rating_behavior",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="number"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="rating_timing",
         *          description="rating_timing",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="number"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="comments",
         *          description="comments",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="title",
         *          description="title",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="created_by",
         *          description="created_by",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *  @OA\Response(response="200", description="Add reviews by a customer"),
         *  @OA\Response(response=401, description="Unauthorized"),
         *     security={
         *       {"apiAuth": {}}
         *     }
         * )
         * 
         */
    public function createReview(Request $request) {
      $data = $request->all();
      
      $reviewValidator = $this->reviewValidator->validate($data);

      if ($reviewValidator->fails()) {
      $errors = $reviewValidator->errors();
      return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
      } 
        try {
          $response =  $this->reviewService->createReview($request); 
          return $this->successResponse($response,Config::get('constants.REVIEW_ADDED'),Response::HTTP_CREATED);
        }
        catch (Exception $e) { 
          
            return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }	
    } 
   
    public function updateReview(Request $request, $id) {
      $data = $request->all();
      $reviewValidator = $this->reviewValidator->validate($data);
      try {
        $response = $this->reviewService->updateReview($data, $id);
        return $this->successResponse($response, Config::get('constants.RECORD_UPDATED'), Response::HTTP_CREATED);

    } catch (Exception $e) {
        return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
    }
    }

    public function deleteReview($id) {

      try{
        $response = $this->reviewService->deleteReview($id);
        return $this->successResponse($response, Config::get('constants.RECORD_REMOVED'), Response::HTTP_ACCEPTED);
      }
      catch (Exception $e){
          return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      } 
     
    }

    public function getReview($id) {

      try{
        $result= $this->reviewService->getReview($id);
      }
      catch (Exception $e){
          return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      }
      return $this->successResponse($result, Config::get('constants.RECORD_FETCHED'), Response::HTTP_ACCEPTED);
    }
    public function getReviewByBid($bid) {

      try{
        $result= $this->reviewService->getReviewByBid($bid);
      }
      catch (Exception $e){
        
          return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      }
      return $this->successResponse($result, Config::get('constants.RECORD_FETCHED'), Response::HTTP_ACCEPTED);


       
    }
    


}
