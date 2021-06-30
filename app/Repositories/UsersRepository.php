<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class UsersRepository
{
    /**
     * @var Users
     */
    protected $channelRepository;

    public function __construct(Users $users,ChannelRepository $channelRepository)
    {
        $this->users = $users;
        $this->channelRepository = $channelRepository;   
    }
  
    public function Register($request)
    {
        $user = new $this->users;
        $user->name= $request['name'];
        $user->email= $request['email'];
        $user->phone= $request['phone'];
        $user->password= $request['password'];
        $user->created_by= $request['created_by'];
        $otp = rand(10000, 99999);
        $user->otp = $otp;
        $user->save();
        //$sendsms = $this->channelRepository->sendSms($request,$otp);
        //return  $sendsms;
        return  $otp;   
    }
    public function verifyOtp($request){

        $otp = trim($request['otp']);
        $existingOtp = $this->users->get();
        $existingOtp = $existingOtp[0]['otp'];
        //return  $existingOtp;
        if($existingOtp==$otp){
        $this->users->where('otp', $otp)->update(array('is_verified' => '1'));
        $user = $this->users->where('otp', $otp)->get();
        return $user;
        }elseif($existingOtp==$otp){
            return 'invalid otp';
        }
    }

    public function RegisterSession($request)
    {
        //$isError = 0;
        //$errorMessage = true;
        $otp = rand(10000, 99999);
        $mobile = $request['phone'];
        $name = $request['name'];
        $email = $request['email'];
        $password= $request['password'];
        $created_by= $request['created_by'];
        ////$request->request->add(['otp' => $otp]);
        //$sendsms = $this->channelRepository->sendSms($request,$otp);
        //return $sendsms;
        session(['name'=> $name]);
        session(['mobile'=> $mobile]);
        session(['email'=> $email]);
        session(['otp' => $otp]);
        session(['password' => $password]);
        session(['created_by' => $created_by]);
        //Log::info($otp);
        return 'OTP:'. $otp;
    }

    public function submitOtp($request){
        $otp = trim($request['otp']);
            $user = new $this->users;
            
                $user->name= session('name');
                $user->otp= $otp;
                $user->email= session('email');
                $user->phone= session('mobile');
                $user->password= session('password');
                $user->created_by= session('created_by');
                $user->msg_id= session('msgId');
                $user->is_verified= '1';
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
 