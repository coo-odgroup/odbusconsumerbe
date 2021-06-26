<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
//use App\OtpVerify;
use Illuminate\Support\Facades\Log;
use App\Repositories\ChannelRepository;


class UsersRepository
{
    /**
     * @var Users
     */
    protected $users;
    protected $channelRepository;

    public function __construct(Users $users,ChannelRepository $channelRepository)
    {
        $this->users = $users;
        $this->channelRepository = $channelRepository;   
    }
  
    public function Register($request)
    {
        $isError = 0;
        $errorMessage = true;

        $user = new $this->users;
        $user->name= $request['name'];
        $user->email= $request['email'];
        $user->phone= $request['phone'];
        $user->password= $request['password'];
        $user->created_by= $request['created_by'];

        $otp = rand(10000, 99999);
        $user->otp = $otp;
        $user->save();
        return  $user;   

    }


    public function RegisterSession($request)
    {
        $isError = 0;
        $errorMessage = true;
        $otp = rand(10000, 99999);
        $mobile = $request['phone'];
        $name = $request['name'];
        $email = $request['email'];
        $password= $request['password'];
        $created_by= $request['created_by'];
        $request->request->add(['otp' => $otp]);
        $sendsms = $this->channelRepository->sendSms($request);
        //return $sendsms;
        session(['name'=> $name]);
        session(['mobile'=> $mobile]);
        session(['email'=> $email]);
        session(['otp' => $otp]);
        session(['password' => $password]);
        session(['created_by' => $created_by]);
        return 'OTP:'. $otp;
    }

    public function submitOtp($request){
        $otp = trim($request['otp']);
            $user = new $this->users;
                $name = session('name');
                $mobile = session('mobile');
                $email = session('email');
                $password = session('password');
                $created_by = session('created_by');

                $user->name= $name;
                $user->otp= $otp;
                $user->email= $email;
                $user->phone= $mobile;
                $user->password= $password;
                $user->created_by= $created_by;
                $user->save();
                session()->flush();
                return $user;
    }

    public function login($request){
        $user = $this->users->where('email',$request['email'])->orWhere('phone',$request['phone'])->where('password',$request['password'])
        ->first();
            return $user;
    }
}
 