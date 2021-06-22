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
use App\AppValidator\LoginValidator;
use App\Models\Users;
use App\Services\UsersService;

class UsersController extends Controller
{
    use ApiResponser;
    protected $usersService;
    protected $usersValidator;
    protected $loginValidator;

    public function __construct(UsersService $usersService,UsersValidator $usersValidator,loginValidator $loginValidator)
    {
        $this->usersService = $usersService; 
        $this->usersValidator = $usersValidator; 
        $this->loginValidator = $loginValidator; 
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
    $data = $request->only([
      'name','email','phone','password','created_by'
     ]);   
     $usersValidation = $this->usersValidator->validate($data);
   
     if ($usersValidation->fails()) {
       $errors = $usersValidation->errors();
       return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     }
      try {
        $response = $this->usersService->RegisterSession($request);
        return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK); 
    }
     catch (Exception $e) {
      return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
    }  
     
} 
  public function submitOtp(Request $request) 
    {
      $recvOtp = $request['otp'];  
    try {
      if(is_null($recvOtp)){
        return $this->successResponse($recvOtp,Config::get('constants.OTP_NULL'),Response::HTTP_NOT_FOUND);
    }  
      elseif($recvOtp == session('otp')){
      $response =  $this->usersService->submitOtp($request);  
        return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_CREATED);
      }else{
        return $this->successResponse($recvOtp,Config::get('constants.OTP_EXPIRED'),Response::HTTP_NOT_FOUND);
        }
    }
    catch (Exception $e) {
        return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      }   
    }

   public function login(Request $request) 
   {
    $data = $request->only([
      'email','phone','password'
     ]);   
     $LoginValidation = $this->loginValidator->validate($data);
   
     if ($LoginValidation->fails()) {
       $errors = $LoginValidation->errors();
       return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
     }
     try {
     // if(isset($data)){
      $response =  $this->usersService->login($request);  
       return $this->successResponse($response,Config::get('constants.LOGIN'),Response::HTTP_OK);
      //}elseif()){
        //return json_encode(array('msg'=>"User not Registered"));
      //}
   }
   catch (Exception $e) {
       return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
     }   
  }

}
