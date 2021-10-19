<?php

namespace App\Services;

use App\Models\Users;
use App\Repositories\UsersRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UsersService
{
   
    protected $usersRepository;

    
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function Register($data)
    {   
        $user = $this->usersRepository->Register($data);
        return $user;
    }
    public function verifyOtp($data)
    {   
        $user = $this->usersRepository->verifyOtp($data);
        return $user;
    }
    public function login($request)
    {   
        $user = $this->usersRepository->login($request);
        return $user;
    }
    public function userProfile($request){

        $user = $this->usersRepository->userProfile($request);
        return $user;     
    }
    public function BookingHistory($request){

        $result = $this->usersRepository->BookingHistory($request);
        return $result;

        
    }

    public function updateProfile($request, $userId,$token){

        $result = $this->usersRepository->updateProfile($request, $userId,$token);
        return $result;
        // try {
        //     $result = $this->usersRepository->updateProfile($request,$id,$token);
        // } catch (Exception $e) {
        //     throw new InvalidArgumentException(Config::get('constants.INVALID_ARGUMENT_PASSED'));
        // }
        return $result;
        
    }

    
    public function userReviews($request)
    {
        $result = $this->usersRepository->userReviews($request);
        return $result;
    }
}