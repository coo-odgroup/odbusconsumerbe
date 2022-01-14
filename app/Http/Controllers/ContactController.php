<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ContactService;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Repositories\ContactRepository;
use App\AppValidator\ContactValidator;

class ContactController extends Controller
{
    use ApiResponser;
    protected $contactService;
    protected $contactValidator;  
  
    public function __construct(ContactService $contactService, ContactValidator $contactValidator)
        {
            $this->contactService = $contactService;
            $this->contactValidator = $contactValidator;  
        }
/**
         * @OA\Post(
         *     path="/api/saveContacts",
         *     tags={"Add Contacts"},
         *     description="Add Contacts",
         *     summary="Add Contacts",
         *     @OA\Parameter(
         *          name="name",
         *          description="name",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="email",
         *          description="email",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="phone",
         *          description="phone",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="service",
         *          description="service",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="message",
         *          description="message",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="user_id",
         *          description="User Id",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *  @OA\Response(response="200", description="Add Contacts of a acustomer"),
         *  @OA\Response(response=401, description="Unauthorized"),
         *     security={
         *       {"apiAuth": {}}
         *     }
         * )
         * 
         */
    public function save(Request $request)
        {

            $data = $request->all();
      
            $contactValidation = $this->contactValidator->validate($data);
      
            if ($contactValidation->fails()) {
            $errors = $contactValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
            } 
            try {
            $response =  $this->contactService->save($request); 
            return $this->successResponse($response,Config::get('constants.RECORD_ADDED'),Response::HTTP_CREATED);
            }
            catch (Exception $e) { 
            
                return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
            }	
    
    }
 

}
