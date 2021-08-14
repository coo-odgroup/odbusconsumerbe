<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
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
        $query =$this->users->where([
                ['phone', $request['phone']],
                ['phone', '<>', null]
                ])
                ->orWhere([
                ['email', $request['email']],
                ['email', '<>', null]
                ]);
 
        $guestUser = $query->exists();
        
        if(!$guestUser){
            $user = new $this->users;
            $user->name= $request['name'];
            $user->password= bcrypt('odbus123');
            $user->created_by= $request['created_by'];
            $otp = $this->sendOtp($request);
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->otp = $otp;
            $user->save();
            return  $user;
        }else{
            $verifiedUser = $query->first()->is_verified;
            if($verifiedUser==0){
                $otp = $this->sendOtp($request);
                $user = $this->users->where('phone', $request['phone'])->orWhere('email', $request['email'])
                    ->update([
                    'otp' => $otp,
                    'password' => bcrypt('odbus123')
                   ]);
                   return $query->get();
            }
            else{
                    return "Exsting User";
            }
        }
    }
    public function sendOtp($request){
        $otp = rand(10000, 99999);
        if($request['phone']){
            $this->users->phone = $request['phone'];
            $sendsms = $this->channelRepository->sendSms($request,$otp);  
        } 
        elseif($request['email']){
            $this->users->email = $request['email']; 
            $sendEmail = $this->channelRepository->sendEmail($request,$otp);
        }
        return  $otp;
    }
    public function verifyOtp($request){
        $rcvOtp = trim($request['otp']);
        $userId = $request['userId'];
        $existingOtp = $this->users->where('id', $userId)->get('otp');
        $existingOtp = $existingOtp[0]['otp'];
        $user = $this->users->where('id', $userId)->first()->only('name','email');
        if(($rcvOtp=="")){
            return "Null";
            }
        elseif($existingOtp == $rcvOtp){
            $this->users->where('id', $userId)->update(array('is_verified' => '1'));
            $this->users->where('id', $userId)->update(array('otp' => Null));
            return "success"; 
        }
        else{
            return 'Invalid OTP';
        }
    }

    public function login($request){
        $name = $this->users->where('phone', $request['phone'])->orWhere('email', $request['email'])->latest()->first()->name;
        $request->request->add(['name' => $name]);
        $otp = $this->sendOtp($request);
        $user = $this->users->where('phone', $request['phone'])->orWhere('email', $request['email'])->orderBy('id','DESC')->take(1)->update(array('otp' => $otp));

        return  $this->users->where('phone', $request['phone'])->orWhere('email', $request['email'])->latest()->first();                         
        
      }
}   
 