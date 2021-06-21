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
    public function RegisterSession($data)
    {   
        $user = $this->usersRepository->RegisterSession($data);
        return $user;
    }
    
    public function submitOtp($data)
    {   
        $user = $this->usersRepository->submitOtp($data);
        return $user;
    }
    public function login($request)
    {   
        $user = $this->usersRepository->login($request);
        return $user;
    }
    
}