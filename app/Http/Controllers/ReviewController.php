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

    public function getAllReview() {

      $result = $this->reviewService->getAllReview();
      return $this->successResponse($result,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
  
        
    }

    public function createReview(Request $request) {
      $data = $request->all();
      
      $reviewValidator = $this->reviewValidator->validate($data);

      if ($reviewValidator->fails()) {
      $errors = $reviewValidator->errors();
      return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
      } 
        try {
          $response =  $this->reviewService->createReview($request); 
          return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
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

    public function deleteReview ($id) {

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
