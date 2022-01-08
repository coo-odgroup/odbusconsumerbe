<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\CommonValidator;
use App\Services\CommonService;

class CommonController extends Controller
{
    use ApiResponser;
    /**
     * @var cancelTicketService
     */
    protected $commonService;
    protected $commonValidator;
    /**
     * cancelTicketController Constructor
     *
     * @param commonService $commonService
     *
     */
    public function __construct(CommonService $commonService, CommonValidator $commonValidator)
    {
        $this->commonService = $commonService;      
        $this->commonValidator = $commonValidator;      
    }
    /**
     * @OA\Post(
     *     path="/api/CommonService",
     *     tags={"Get all Social media links"},
     *     description="Get all Social media links",
     *     summary="Get all Social media links",
     *     @OA\Parameter(
     *          name="bus_operator_id",
     *          description="bus operator Id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=152,
     *          )
     *      ),
     *  @OA\Response(response="200", description="Get all Social media links"),
     *  @OA\Response(response=401, description="Unauthorized"),
     *     security={
     *       {"apiAuth": {}}
     *     }
     * )
     * 
     */
    public function getAll(Request $request) {        

        $data = $request->all();
        $commonValidation = $this->commonValidator->validate($data);

        if ($commonValidation->fails()) {
        $errors = $commonValidation->errors();
        return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
        } 

         try {
          $response =  $this->commonService->getAll($request);
           return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_PARTIAL_CONTENT);
       }
       catch (Exception $e) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
         }      
   } 
}