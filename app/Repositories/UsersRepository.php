<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
//use App\OtpVerify;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Session;


class UsersRepository
{
    /**
     * @var Users
     */
    protected $users;

    public function __construct(Users $users)
    {
        $this->users = $users;    
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
        
    //    $mobile = $request['phone'];
    //    $name = $request['name'];
    //    $email = $request['email'];
    //    $apiKey = urlencode('aCFowBsUJ8k-KB0egbyZ1Af6IAgX9Gvux2WBp6w2uP');
    //    //$sender = urlencode('ODTKTS');
    //    $sender = urlencode('ODBUSS');
    // //    $message = rawurlencode('PNR: 12345, Bus Details: gajanan, DOJ: 23-12-21, Route: cuttack, Dep: 12.30, Name: deepak, Gender: M, Seat: 1A, Fare: 230, Conductor Mob: 9987563412 - OD RPBOA');
    //    $message = rawurlencode('Dear $name,Your OTP is $otp, to login ODBUS. Thanks - ODBUS');
    //    $route_no = 4; 
    //    $response_type = "json"; 
    //    //$message = rawurlencode("Hello" . $user . "Your OTP is " . $otp );
    //    $data = array('apikey' => $apiKey, 'numbers' => $mobile, "sender" => $sender, "message" => $message);
    //    $ch = curl_init('https://api.textlocal.in/send/');
    //    curl_setopt($ch, CURLOPT_POST, true);
    //    curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
    //    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //    $response = curl_exec($ch);
    //    return $response;

    //    if (curl_errno($ch)) {
    //        $isError = true;
    //        $errorMessage = curl_error($ch);
    //    }

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

    //    $apiKey = urlencode('aCFowBsUJ8k-KB0egbyZ1Af6IAgX9Gvux2WBp6w2uP');
    //    //$sender = urlencode('ODTKTS');
    //    $sender = urlencode('ODBUSS');
    //    $message = rawurlencode('Dear $name,Your OTP is $otp, to login ODBUS. Thanks - ODBUS');
    //    //$message = rawurlencode('PNR: 12345, Bus Details: gajanan, DOJ: 23-12-21, Route: cuttack, Dep: 12.30, Name: deepak, Gender: M, Seat: 1A, Fare: 230, Conductor Mob: 9987563412 - OD RPBOA');
    //    $route_no = 4; 
    //    $response_type = "json"; 
    //    $data = array('apikey' => $apiKey, 'numbers' => $mobile, "sender" => $sender, "message" => $message);
    //    $ch = curl_init('https://api.textlocal.in/send/');
    //    curl_setopt($ch, CURLOPT_POST, true);
    //    curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
    //    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //    $response = curl_exec($ch);
    //     return $response;

       session(['name'=> $name]);
       session(['mobile'=> $mobile]);
       session(['email'=> $email]);
       session(['otp' => $otp]);
       session(['password' => $password]);
       session(['created_by' => $created_by]);
        return 'OTP:'. $otp;
        //return json_encode(array('msg'=>'otp : '. $otp));
    }

    public function submitOtp($request){
        $otp = trim($request['otp']);
        // if($otp==''){
        //     return '';
        // }
        //else{
            //$user = new OtpVerify;
            $user = new $this->users;
            //if($otp == session('otp')){
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
           // }
            //else{
                //return json_encode(array('statusCode'=>400,'msg'=>"otp expired"));
            //}
        //}
    }

    public function login($request){
        $user = $this->users->where('email',$request['email'])->orWhere('phone',$request['phone'])->where('password',$request['password'])
        ->first();
        //return $user;
        if(isset($user)){
            return $user;
        }
        else{
            return json_encode(array('msg'=>"User not Registered"));
        }
       
    }


}
 