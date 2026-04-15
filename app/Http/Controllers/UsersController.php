<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\UsersValidator;
use App\AppValidator\LoginValidator;
use App\AppValidator\ResendotpValidator;
use App\AppValidator\UserProfileValidator;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Services\UsersService;
use App\Services\NotificationService;
use App\AppValidator\NotificationValidator;

class UsersController extends Controller
{
  use ApiResponser;
  protected $usersService;
  protected $usersValidator;
  protected $loginValidator;
  protected $userProfileValidator;
  protected $notificationService;
  protected $notificationValidator;
  protected $resendotpValidator;

  public function __construct(UsersService $usersService, UsersValidator $usersValidator, loginValidator $loginValidator, UserProfileValidator $userProfileValidator, NotificationService $notificationService, NotificationValidator $notificationValidator, ResendotpValidator $resendotpValidator)
  {
    $this->usersService = $usersService;
    $this->usersValidator = $usersValidator;
    $this->loginValidator = $loginValidator;
    $this->userProfileValidator = $userProfileValidator;
    $this->notificationService = $notificationService;
    $this->notificationValidator = $notificationValidator;
    $this->resendotpValidator = $resendotpValidator;
  }

  public function Register(Request $request)
  {
    $data = $request->only([
      'name',
      'email',
      'phone',
      'password',
      'created_by'
    ]);

    $usersValidation = $this->usersValidator->validate($data);

    if ($usersValidation->fails()) {
      $errors = $usersValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->Register($request);
      if ($response != 'Existing User') {
        return $this->successResponse($response, Config::get('constants.OTP_GEN'), Response::HTTP_OK);
      } else {
        return $this->errorResponse($response, Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }

  public function verifyOtp(Request $request)
  {
    $data = $request->all();
    $verify = $this->usersService->verifyOtp($request);
    if ($verify == '') {
      return $this->errorResponse(Config::get('constants.OTP_NULL'), Response::HTTP_OK);
    } elseif ($verify == 'Inval OTP') {
      return $this->errorResponse(Config::get('constants.OTP_INVALID'), Response::HTTP_OK);
    } elseif ($verify == 'Invalid User ID') {
      return $this->errorResponse(Config::get('constants.USER_INVALID'), Response::HTTP_OK);
    } else {
      return $this->successResponse($verify, Config::get('constants.VERIFIED'), Response::HTTP_OK);
    }
  }

  public function login(Request $request)
  {

    $data = $request->all();
    $LoginValidation = $this->loginValidator->validate($data);

    if ($LoginValidation->fails()) {
      return $this->errorResponse(Config::get('constants.UN_REGISTERED'), Response::HTTP_OK);

      // $errors = $LoginValidation->errors();
      // return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->login($request);
      if ($response != 'un_registered') {
        return $this->successResponse($response, Config::get('constants.OTP_GEN'), Response::HTTP_OK);
      } else {
        return $this->errorResponse(Config::get('constants.UN_REGISTERED'), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }

  protected function createNewToken($token)
  {
    $loginUser = [
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => Auth::factory()->getTTL() * 60,
      'user' => Auth::user()
    ];
    return $this->successResponse($loginUser, Config::get('constants.OTP_VERIFIED'), Response::HTTP_OK);
  }

  public function userProfile(Request $request)
  {

    $userDetails = $this->usersService->userProfile($request);

    if ($userDetails == 'Invalid') {
      return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
    } else {
      return $this->successResponse($userDetails, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
  }

  public function updateProfile(Request $request)
  {

    $data = $request->all();
    $userProfileValidation = $this->userProfileValidator->validate($data);

    if ($userProfileValidation->fails()) {
      $errors = $userProfileValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->updateProfile($request);
      if ($response == 'Invalid') {
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
      } else {
        return $this->successResponse($response, Config::get('constants.PROFILE_UPDATED'), Response::HTTP_CREATED);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }

  public function updateProfileImage(Request $request)
  {
    $data = $request->all();

    // $userProfileValidation = $this->userProfileValidator->validate($data);

    // if ($userProfileValidation->fails()) {
    //   $errors = $userProfileValidation->errors();
    //   return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
    // }
    try {
      $response = $this->usersService->updateProfileImage($request);
      if ($response == 'Invalid') {
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
      } else {
        return $this->successResponse($response, Config::get('constants.PROFILE_UPDATED'), Response::HTTP_CREATED);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }


  public function refreshToken()
  {

    $res = [
      'access_token' => Auth::refresh(),
      'token_type' => 'bearer',
      'expires_in' =>Auth::factory()->getTTL() * 60,
      'user' => Auth::user()
    ];

    return $this->successResponse($res, Config::get('constants.REFRESH_TOKEN'), Response::HTTP_OK);
  }

  public function BookingHistory(Request $request)
  {

    $data = $request->all();
    $response =  $this->usersService->BookingHistory($request);
    if ($response == 'Invalid') {
      return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
    } else {
      return $this->successResponse($response, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
  }


  public function AppBookingHistory(Request $request)
  {

    $data = $request->all();
    $response =  $this->usersService->AppBookingHistory($request);
    if ($response == 'Invalid') {
      return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
    } else {
      return $this->successResponse($response, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }
  }


  public function userReviews(Request $request)
  {
    $data = $request->all();
    $userReviewsValidation = $this->userProfileValidator->validate($data);

    if ($userReviewsValidation->fails()) {
      $errors = $userReviewsValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response =  $this->usersService->userReviews($request);
      if ($response == 'Invalid') {
        return $this->errorResponse(Config::get('constants.INVALID_TOKEN'), Response::HTTP_OK);
      } else {
        return $this->successResponse($response, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }

  public function sendNotification(Request $request)
  {

    $data = $request->all();
    $notificationValidation = $this->notificationValidator->validate($data);

    if ($notificationValidation->fails()) {
      $errors = $notificationValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response =  $this->notificationService->sendNotification($request);
      if ($response == 'failed') {
        return $this->errorResponse(Config::get('constants.PUSH_NTFY_FAILED'), Response::HTTP_OK);
      } else {
        return $this->successResponse($response, Config::get('constants.NOTIFICATION_SENT'), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }

  /////////ANDROID USE///////////////////
  public function resendOTP(Request $request)
  {

    $data = $request->all();
    $resendotpValidation = $this->resendotpValidator->validate($data);

    if ($resendotpValidation->fails()) {
      $errors = $resendotpValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->resendOTP($request);
      if ($response == 'un_registered') {
        return $this->errorResponse(Config::get('constants.UN_REGISTERED'), Response::HTTP_OK);
      } elseif ($response == 'record_not_found') {
        return $this->errorResponse(Config::get('constants.NO_RECORD_FOUND'), Response::HTTP_OK);
      } else {
        return $this->successResponse($response, Config::get('constants.OTP_GEN'), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }


  public function loginweb(Request $request)
  {

    $arrParam = json_decode(decryptRequest($request['REQUEST_DATA']));
    $request['phone'] = $data['phone'] = isset($arrParam->phone) ? $arrParam->phone : null;
    $request['email'] = $data['email'] = isset($arrParam->email) ? $arrParam->email : null;

    $LoginValidation = $this->loginValidator->validate($data);

    if ($LoginValidation->fails()) {
      return $this->errorResponse(Config::get('constants.UN_REGISTERED'), Response::HTTP_OK);

      // $errors = $LoginValidation->errors();
      // return $this->errorResponse($errors->toJson(),Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->login($request);
      if ($response != 'un_registered') {
        return $this->successResponse(encryptResponse($response), Config::get('constants.OTP_GEN'), Response::HTTP_OK);
      } else {
        return $this->errorResponse(Config::get('constants.UN_REGISTERED'), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }


  public function verifyOtpweb(Request $request)
  {

    $arrParam = json_decode(decryptRequest($request['REQUEST_DATA']));
    $request['otp'] = $arrParam->otp;
    $request['userId'] = $arrParam->userId;

    $verify = $this->usersService->verifyOtp($request);
    if ($verify == '') {
      return $this->errorResponse(Config::get('constants.OTP_NULL'), Response::HTTP_OK);
    } elseif ($verify == 'Inval OTP') {
      return $this->errorResponse(Config::get('constants.OTP_INVALID'), Response::HTTP_OK);
    } elseif ($verify == 'Invalid User ID') {
      return $this->errorResponse(Config::get('constants.USER_INVALID'), Response::HTTP_OK);
    } else {
      return $this->successResponse(encryptResponse($verify), Config::get('constants.VERIFIED'), Response::HTTP_OK);
    }
  }


  public function Registerweb(Request $request)
  {

    $arrParam = json_decode(decryptRequest($request['REQUEST_DATA']));
    $request['name'] = $arrParam->name;
    $request['email'] = $arrParam->email;
    $request['phone'] = $arrParam->phone;
    $request['created_by'] = $arrParam->created_by;


    $data = $request->only([
      'name',
      'email',
      'phone',
      'created_by'
    ]);

    $usersValidation = $this->usersValidator->validate($data);

    if ($usersValidation->fails()) {
      $errors = $usersValidation->errors();
      return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
    }
    try {
      $response = $this->usersService->Register($request);
      if ($response != 'Existing User') {
        return $this->successResponse(encryptResponse($response), Config::get('constants.OTP_GEN'), Response::HTTP_OK);
      } else {
        return $this->errorResponse(encryptResponse($response), Response::HTTP_OK);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
    }
  }
}
