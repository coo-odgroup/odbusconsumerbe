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
        if($request['phone']){
            $user->phone = $request['phone'];
            //$sendsms = $this->channelRepository->sendSms($request,$otp);  
        } 
        elseif($request['email']){
            $user->email = $request['email']; 
            //$sendEmail = $this->channelRepository->sendEmail($request,$otp);
        }
        $user->save();
        return  $user;   
    }
    public function verifyOtp($request){
        $rcvOtp = trim($request['otp']);
        $userId = $request['userId'];
        $existingOtp = $this->users->where('id', $userId)->get('otp');
        $existingOtp = $existingOtp[0]['otp'];
        $user = $this->users->where('id', $userId)->first()->only('name','email');
        //$user['password'] = 'odbus123';
        if(($rcvOtp=="")){
            return "Null";
            }
        elseif($existingOtp == $rcvOtp){
            $this->users->where('id', $userId)->update(array('is_verified' => '1'));
            $this->users->where('id', $userId)->update(array('otp' => Null));
            //$user = $this->users->where('id', $userId)->get();
 
            return "success"; 
        }
        else{
            return 'Invalid OTP';
        }
    }
    public function login($request){

      $otp = rand(10000, 99999);

      if($request['phone']){
        $users = $this->users->where('phone', $request['phone'])->update(array('otp' => $otp));
        $users = $this->users->where('phone', $request['phone'])->get();
        //$sendsms = $this->channelRepository->sendSms($request,$otp); 
        return $users; 
      } 
      elseif($request['email']){
        $users = $this->users->where('email', $request['email'])->update(array('otp' => $otp));
        $users = $this->users->where('email', $request['email'])->get();
        //$sendEmail = $this->channelRepository->sendEmail($request,$otp);
        return $users;
      }
    }
}
 