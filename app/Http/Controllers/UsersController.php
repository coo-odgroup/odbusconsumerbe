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
            return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK);  
        }
         catch (Exception $e) {
          return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
        }       
   } 

   public function verifyOtp(Request $request) 
    {
    try {
      $recvOtp = $request['otp'];
      if(is_null($recvOtp)){
        return $this->successResponse($recvOtp,Config::get('constants.OTP_NULL'),Response::HTTP_NOT_FOUND);
    }  
      else{
      $response =  $this->usersService->verifyOtp($request);  
      return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_CREATED);
      }
    }
    catch (Exception $e) {
        return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      }   
    }

/**
 * @OA\Post(
 *     path="/api/RegisterSession",
 *     tags={"RegisterSession API"},
 *     description="All user information taken and generarted OTP sent to users",
 *     summary="send OTP to user for registration",
 *     @OA\Parameter(
 *          name="name",
 *          description="name of user",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="email",
 *          description="email of user",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="mobile number of user",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="password",
 *          description="password given by user",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="created_by",
 *          description="created by",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="200", description="OTP generated and sent to user for registration")
 * )
 * 
 */
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

/**
 * @OA\Post(
 *     path="/api/submitOtp",
 *     tags={"submitOtp API"},
 *     description="user Registration with OTP verification sent by user",
 *     summary="user Registration with OTP verification",
 *     @OA\Parameter(
 *          name="otp",
 *          description="otp sent by user",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *     @OA\Response(response="201", description="Registered successfully"),
 *     @OA\Response(response="404", description="Not Found")
 * )
 * 
 */
  public function submitOtp(Request $request) 
    {
    try {
      $recvOtp = $request['otp'];
      if(is_null($recvOtp)){
        return $this->errorResponse(Config::get('constants.OTP_NULL'),Response::HTTP_PARTIAL_CONTENT);
    }  
      elseif($recvOtp == session('otp')){
      $response =  $this->usersService->submitOtp($request);  
        return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_CREATED);
      }
      else{
        return $this->errorResponse(Config::get('constants.OTP_EXPIRED'),Response::HTTP_PARTIAL_CONTENT);
        }
    }
    catch (Exception $e) {
        return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
      }   
    }
    
    /**
 * @OA\Post(
 *     path="/api/Login",
 *     tags={"Login API"},
 *     description="user Login entering either phone no or email",
 *     summary="user Login input either phone no or email",
 *     @OA\Parameter(
 *          name="phone",
 *          description="phone no of user",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="email",
 *          description="email of user",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *       @OA\Parameter(
 *          name="password",
 *          description="password given by user",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *     @OA\Response(response="200", description="Login Successful"),
 *     @OA\Response(response="206", description="phone no or email of user required"),
 *     @OA\Response(response="404", description="not a registerd user")
 * )
 * 
 */  
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
      $user = Users::where('email',$request['email'])->orWhere('phone',$request['phone'])->where('password',$request['password'])
      ->where('is_verified','1') 
      ->first();
      if(isset($user)){
      //$response =  $this->usersService->login($request);  
       return $this->successResponse($user,Config::get('constants.LOGIN'),Response::HTTP_OK);
      }else{
        return $this->errorResponse(Config::get('constants.USER_NOTREG'),Response::HTTP_PARTIAL_CONTENT);
      }
   }
   catch (Exception $e) {
       return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
     }   
  }

}
