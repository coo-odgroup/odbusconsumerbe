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
