<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Auth;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

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
        $user->password= bcrypt('odbus123');
        $user->created_by= $request['created_by'];
        $otp = rand(10000, 99999);
        $user->otp = $otp;
        //$user->save();
        if($request['phone']){
            $user->phone = $request['phone'];
            $sendsms = $this->channelRepository->sendSms($request,$otp);  
        } 
        elseif($request['email']){
            $user->email = $request['email']; 
            $sendEmail = $this->channelRepository->sendEmail($request,$otp);
        }
        $user->save();
        //return $sendEmail;
        //return  $sendsms;
        return  $user;   
    }
    public function verifyOtp($request){

        $rcvOtp = trim($request['otp']);
        $userId = $request['userId'];
        $existingOtp = $this->users->where('id', $userId)->get('otp');
        $existingOtp = $existingOtp[0]['otp'];
        if(($rcvOtp=="")){
        return "Null";
        }
        elseif($existingOtp == $rcvOtp){
        $this->users->where('id', $userId)->update(array('is_verified' => '1'));
        $this->users->where('id', $userId)->update(array('otp' => Null));
        $user = $this->users->where('id', $userId)->get();
        return "reg done"; 
        }
        else{
            return 'Invalid OTP';
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

      $otp = rand(10000, 99999);
      $users = $this->users->where('email', $request['email'])->update(array('otp' => $otp));
      //$sendsms = $this->channelRepository->sendSms($request,$otp);
      $sendEmail = $this->channelRepository->sendEmail($request,$otp);
    }

    public function verifyOtpLogin($request){

        $rcvOtp = trim($request['otp']);
        $userId = $request['userId'];
        $existingOtp = $this->users->where('id', $userId)->get('otp');
        $existingOtp = $existingOtp[0]['otp'];
        if(($rcvOtp=="")){
        return "Null";
        }
        elseif($existingOtp == $rcvOtp){
        $this->users->where('id', $userId)->update(array('otp' => Null));
        return "Login done"; 
        }
        else{
            return 'Invalid OTP';
        }
    }
}
 