<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\UsersValidator;
use App\AppValidator\LoginValidator;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Services\UsersService;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
/**
 * @OA\Post(
 *     path="/api/Register",
 *     tags={"Register API"},
 *     description="user detatils saved and otp generated",
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
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="mobile number of user",
 *          required=false,
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
 *     @OA\Response(response="200", description="otp generated"),
 *     @OA\Response(response="206", description="not a valid credential"),
 * )
 * 
 */
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
         if($response!='Exsting User')
         {
            return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK);
         }else{
            return $this->successResponse($response,Config::get('constants.REGISTERED'),Response::HTTP_OK);
         }
       }
       catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
       }        
   } 
   
    /**
 * @OA\Post(
 *     path="/api/VerifyOtp",
 *     tags={"JWT Auth"},
 *     description="otp verification and  generating authentication token",
 *     summary="otp verification and  generating authentication token",
 *     @OA\Parameter(
 *          name="userId",
 *          description="user Id",
 *          required=true,
 *          in="query",
 *          @OA\Schema( 
 *              type="string",
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="otp",
 *          description="otp set to user",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *     @OA\Response(response="200", description="Registered successfully"),
 *     @OA\Response(response="206", description="otp not provided"),
 *     @OA\Response(response="406", description="Invalid otp")
 * )
 * 
 */  

   public function verifyOtp(Request $request) 
   {
    $data = $request->all();
    $user = Users::where('id', $data)->first()->only('name','email','phone');
    $user['password'] = 'odbus123';
    $response = $this->usersService->verifyOtp($request); 
      if($response == 'Null'){
        return $this->successResponse(Config::get('constants.OTP_NULL'),Response::HTTP_BAD_REQUEST);
    }  
      elseif($response == 'success'){
        try {
          if (! $token = Auth()->attempt($user)) {
            return $this->errorResponse(Config::get('constants.WRONG_CREDENTIALS'),Response::HTTP_UNPROCESSABLE_ENTITY );
            }
            return $this->createNewToken($token);
          }
          catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
          }  
      return $this->successResponse(Config::get('constants.VERIFIED'),Response::HTTP_OK);
    }
      else{
      return $this->errorResponse(Config::get('constants.OTP_INVALID'),Response::HTTP_NOT_ACCEPTABLE);
      }
    }

/**
 * @OA\Post(
 *     path="/api/Login",
 *     tags={"Login API"},
 *     description="user login using phone or email",
 *     summary="user login using phone or email",
 *     @OA\Parameter(
 *          name="phone",
 *          description="phone of user",
 *          required=false,  
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
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
 *     @OA\Response(response="200", description="otp generated"),
 *     @OA\Response(response="206", description="not a valid credential"),
 * )
 * 
 */
  public function login(Request $request){  

    $data = $request->all();  
    $LoginValidation = $this->loginValidator->validate($data);
     
    if ($LoginValidation->fails()) {
      $errors = $LoginValidation->errors();
      return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->login($request);
      return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK);  
  }
   catch (Exception $e) {
    return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
  }        

}

protected function createNewToken($token){
  $loginUser = [  
       'access_token' => $token,
       'token_type' => 'bearer',
       'expires_in' => Auth()->factory()->getTTL() * 60,
       'user' => Auth()->user()   
 ]; 
 return $this->successResponse($loginUser,Config::get('constants.OTP_VERIFIED'),Response::HTTP_OK);
}
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     name="Token based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
 /**
 * @OA\Get(
 *  path="/api/UserProfile",
 *  summary="Get user details",
 *  tags={"JWT Auth"},
 *  @OA\Response(response=200, description="Authorized User details"),
 *  @OA\Response(response=401, description="Unauthorized user"),
 *  security={{ "apiAuth": {} }}
 * )
 */

  
public function userProfile() {
  $user = auth()->user();
  if(!is_null($user)) {
    return $this->successResponse($user,Config::get('constants.USER_DETAILS'),Response::HTTP_OK);
  }
  else {
    return $this->errorResponse(Config::get('constants.USER_UNAUTHORIZED'),Response::HTTP_UNAUTHORIZED);
  }
}

public function refreshToken() {
  return $this->createNewToken(auth()->refresh());
  }
}
