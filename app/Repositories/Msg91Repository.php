<?php

namespace App\Repositories;

use App\Services\Msg91Service;

class Msg91Repository
{
    protected $msg91Service;

    public function __construct(Msg91Service $msg91Service)
    {
        $this->msg91Service = $msg91Service;
    }

    public function sendSms($request, $otp)
    {
        $name = $request['name'];
        $mobile = $request['phone'];
        $variables = [

            "body_1" => ["type" => "text", "value" => $otp],
            "button_1" => ["type" => "text", "value" => $otp],

            "var1" => ["type" => "text", "value" => $name],
            "var2" => ["type" => "text", "value" => $otp],

        ];
        $data = $this->msg91Service->otpsend($mobile, $variables);
    }
}
