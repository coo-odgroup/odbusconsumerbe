<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\UsersValidator;
use App\Models\Users;
use App\Services\UsersService;

class UsersController extends Controller
{
    use ApiResponser;
    protected $usersService;
    protected $usersValidator;

    public function __construct(UsersService $usersService,UsersValidator $usersValidator)
    {
        $this->usersService = $usersService; 
        $this->usersValidator = $usersValidator; 
    }

    public function Register(Request $request) {
        $data = $request->only([
           'name','email','phone','password','created_by'
          ]);   
          $usersValidation = $this->usersValidator->validate($data);
        
          if ($usersValidation->fails()) {
            $errors = $usersValidation->errors();
            return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
          }
          try {
            $response = $this->usersService->Register($request);
            return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_CREATED); 
        }
         catch (Exception $e) {
          return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
        }       
   } 

   public function RegisterSession(Request $request) {
  
      try {
        $response = $this->usersService->RegisterSession($request);
        return $this->successResponse($response,Config::get('constants.OTP_VERIFIED'),Response::HTTP_CREATED); 
    }
     catch (Exception $e) {
      return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
    }  
     
} 
public function submitOtp(Request $request) 
{
 try {
   $response =  $this->usersService->submitOtp($request);  
    return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_OK);
}
catch (Exception $e) {
    return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
  }   
}

   public function login(Request $request) 
   {
  
     try {
      $response =  $this->usersService->login($request);  
       return $this->successResponse($response,Config::get('constants.LOGIN'),Response::HTTP_CREATED);
   }
   catch (Exception $e) {
       return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
     }   
  }

}
