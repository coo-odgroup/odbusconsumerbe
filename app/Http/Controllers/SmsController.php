<?php

namespace App\Http\Controllers;

use App\Services\Msg91Service;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send(Request $request, Msg91Service $msg91)
    {
        $mobile = 9692066142;

        $data = [
            'var1'  => 'sk sahil',
            'var2'  => 'ODCL1689894',
            'var3'  => 'Bhubaneswar',
            'var4'  => 'Raj Khariar',
            'var5'  => 'NILKANTHESWAR',
            'var6'  => 'OR 02 B 2525',
            'var7'  => '15-12-2020, 20:55',
            'var8'  => 'sk sahil',
            'var9'  => '14,15,16,17 SL 13,14',
            'var10' => '2560.32',
            'var11' => '9348249712',
        ];

        $response = $msg91->sendBookingSms($mobile, $data);

        return response()->json($response);
    }

    // public function sendWhatsappCampaign(Msg91Service $msg91)
    // {
    //     $otp = 123456;

    //     $variables = [

    //         "body_1" => ["type" => "text", "value" => $otp],
    //         "button_1" => ["type" => "text", "value" => $otp],

    //         "var1" => ["type" => "text", "value" => "Sahil"],
    //         "var2" => ["type" => "text", "value" => $otp],

    //     ];

    //     $mobile = [9692066142];

    //     $response = $msg91->sendWhatsappCampaign($mobile, config('msg91.campaigns.otp'), $variables);

    //     return response()->json($response);
    // }

    public function sendWhatsappCampaign(Msg91Service $msg91)
    {
        $variables = [

            // ✅ Header Image
            "header_1" => [
                "type" => "image",
                "value" => "https://provider.odbus.co.in/public/uploads/logo/ODBUS_YELLOW_BG_LOGOWHATSAPP-1.jpg"
            ],

            // ✅ WhatsApp body
            "body_var_1"  => ["type" => "text", "value" => "OD123456"],
            "body_var_2"  => ["type" => "text", "value" => "Nilkantheswar"],
            "body_var_3"  => ["type" => "text", "value" => "OR02B2525"],
            "body_var_4"  => ["type" => "text", "value" => "15-12-2026"],
            "body_var_5"  => ["type" => "text", "value" => "20:55"],
            "body_var_6"  => ["type" => "text", "value" => "Bhubaneswar"],
            "body_var_7"  => ["type" => "text", "value" => "Baramunda"],
            "body_var_8"  => ["type" => "text", "value" => "Cuttack"],
            "body_var_9"  => ["type" => "text", "value" => "Badambadi"],
            "body_var_10" => ["type" => "text", "value" => "Sahil"],
            "body_var_11" => ["type" => "text", "value" => "A1,A2"],
            "body_var_12" => ["type" => "text", "value" => "9692066142"],

            // ✅ SMS
            "var1"  => ["type" => "text", "value" => "OD123456"],
            "var2"  => ["type" => "text", "value" => "Nilkantheswar"],
            "var3"  => ["type" => "text", "value" => "OR02B2525"],
            "var4"  => ["type" => "text", "value" => "15-12-2026"],
            "var5"  => ["type" => "text", "value" => "20:55"],
            "var6"  => ["type" => "text", "value" => "Bhubaneswar"],
            "var7"  => ["type" => "text", "value" => "Cuttack"],
            "var8"  => ["type" => "text", "value" => "Sahil"],
            "var9"  => ["type" => "text", "value" => "A1,A2"],
            "var10" => ["type" => "text", "value" => "9692066142"],
        ];

        $mobile = [9692066142];

        $response = $msg91->sendWhatsappCampaign($mobile, config('msg91.campaigns.otp'), $variables);

        return response()->json($response);
    }
}
