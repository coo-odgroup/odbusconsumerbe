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
//use JWTAuth;
//use Tymon\JWTAuth\Exceptions\JWTException;

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
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
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
         if($response!='Existing User')
         {
            return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK);
         }else{
            return $this->errorResponse($response,Response::HTTP_OK);
         }
       }
       catch (Exception $e) {
         return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
       }        
   } 
   
    /**
 * @OA\Post(
 *     path="/api/VerifyOtp",
 *     tags={"Verify Otp"},
 *     description="otp verification",
 *     summary="otp verification",
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
 *          description="otp sent to user",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *     @OA\Response(response="200", description="Registered successfully"),
 *     @OA\Response(response="206", description="otp not provided"),
 *     @OA\Response(response="406", description="Invalid otp"),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 * 
 */  

   public function verifyOtp(Request $request) 
   {
    $data = $request->all();
    $verify = $this->usersService->verifyOtp($request);
    if($verify == ''){
      return $this->errorResponse(Config::get('constants.OTP_NULL'),Response::HTTP_OK);
    }elseif($verify == 'Inval OTP'){
     return $this->errorResponse(Config::get('constants.OTP_INVALID'),Response::HTTP_OK);
    }
    elseif($verify == 'Invalid User ID'){
      return $this->errorResponse(Config::get('constants.USER_INVALID'),Response::HTTP_OK);
     }
    else{
    return $this->successResponse($verify,Config::get('constants.VERIFIED'),Response::HTTP_OK);
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
 *     @OA\Response(response=401, description="Unauthorized"),
 *     security={
 *       {"apiAuth": {}}
 *     }
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
      if($response!='un_registered')
      {
         return $this->successResponse($response,Config::get('constants.OTP_GEN'),Response::HTTP_OK);
      }else{
        return $this->successResponse($response,Config::get('constants.UN_REGISTERED'),Response::HTTP_OK);
      }
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
 * @OA\Get(
 *  path="/api/UserProfile",
 *  summary="Get user details",
 *  tags={"User Profile"},
 *  @OA\Response(response=200, description="Authorized User details"),
 *  @OA\Response(response=401, description="Unauthorized user"),
 *  security={{ "apiAuth": {} }}
 * )
 */
  
public function userProfile(Request $request) {
 
  $userDetails = $this->usersService->userProfile($request);
  
   if($userDetails=='Invalid'){
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'),Response::HTTP_OK);
      }
      else{
        return $this->successResponse($userDetails,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
      } 
}
   /**
   * @OA\Put(
   *     path="/api/updateProfile/{id}{token}",
   *     tags={"update User Profile"},
   *     summary="Update User Profile",
   *     @OA\Parameter(
   *         description="User Id",
   *         in="path",
   *         name="id",
   *         required=true,
   *          @OA\Schema(
   *              type="integer"
   *          )
   *     ),
   *     @OA\Parameter(
   *         description="User Token",
   *         in="path",
   *         name="token",
   *         required=true,
   *          @OA\Schema(
   *              type="string"
   *          )
   *     ),
   *     @OA\Parameter(
   *          name="name",
   *          description="user name",
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="email",
   *          description="user email",
   *          required=true,
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="pincode",
   *          description="pincode",
   *          in="query",
   *          @OA\Schema(
   *              type="number"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="street",
   *          description="street",
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="district",
   *          description="district",
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="address",
   *          description="address",
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *     @OA\Parameter(
   *          name="profile_image",
   *          description="profile image",
   *          in="query",
   *          @OA\Schema(
   *              type="string"
   *          )
   *      ),
   *  @OA\Response(response=200, description="Update User Profile"),
   *  @OA\Response(response="404", description="Record not Found"),
   *  @OA\Response(response=401, description="Unauthorized user"),
   *  security={{ "apiAuth": {} }}
   * )
   */ 
  public function updateProfile(Request $request) {
      $response = $this->usersService->updateProfile($request); 
    
      if($response=='Invalid'){
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'),Response::HTTP_OK);
      }
      else{
        return $this->successResponse($response,Config::get('constants.PROFILE_UPDATED'),Response::HTTP_CREATED);
      }
}
  

public function refreshToken() {

  $res = [  
    'access_token' => auth()->refresh(),
    'token_type' => 'bearer',
    'expires_in' => Auth()->factory()->getTTL() * 60,
    'user' => Auth()->user() 
]; 

   return $this->successResponse($res,Config::get('constants.REFRESH_TOKEN'),Response::HTTP_OK);
}
/**
         * @OA\Post(
         *     path="/api/BookingHistory",
         *     tags={"Booking History of a Customer"},
         *     description="Get Booking History of a Customer",
         *     summary="Get Booking History of a Customer",
         *     @OA\Parameter(
         *          name="status",
         *          description="status",
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="paginate",
         *          description="paginate",
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="filter",
         *          description="filter",
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
         *          )
         *      ),
         *     @OA\Parameter(
         *          name="userId",
         *          description="user Id",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="integer"
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
         *          name="token",
         *          description="token",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *      ),
         *  @OA\Response(response="200", description="Get Booking Details Of a Customer"),
         *  @OA\Response(response=401, description="Unauthorized"),
         *     security={
         *       {"apiAuth": {}}
         *     }
         * )
         * 
         */
  public function BookingHistory(Request $request){  

    $data = $request->all();    
      $response =  $this->usersService->BookingHistory($request); 
      if($response=='Invalid'){
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'),Response::HTTP_OK);
      }
      else{
        return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
      }
  }
  /**
 * @OA\Get(path="/api/UserReviews",
 *   tags={"User Reviews"},
 *   summary="Get userReviews of an authenticated user",
 *   description="Get user  review details",
 *   operationId="getAuthUser",
 *   @OA\Response(
 *     response=200,
 *     description="authorized user reviews",
 *     @OA\Schema(type="string"),
 *     @OA\Header(
 *       header="X-Rate-Limit",
 *       @OA\Schema(
 *           type="integer",
 *           format="int32"
 *       ),
 *     ),
 *     @OA\Header(
 *       header="X-Expires-After",
 *       @OA\Schema(
 *          type="string",
 *          format="date-time",
 *       ),
 *     )
 *   ),
 *  @OA\Response(response=401, description="Unauthorized user"),
 *     security={
 *       {"apiAuth": {}}
 *     }
 * )
 */
  public function userReviews(Request $request)
  {      
      $response =  $this->usersService->userReviews($request); 
      if($response=='Invalid'){
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'),Response::HTTP_OK);
      }
      else{
        return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
      }
  }


}
