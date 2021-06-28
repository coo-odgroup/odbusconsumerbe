<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\GatewayInformation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class ChannelRepository
{
    protected $gatewayInformation;
    public function __construct(GatewayInformation $gatewayInformation)
    {
        $this->gatewayInformation = $gatewayInformation; 
    } 
    
    public function storeGWInfo($data) {
        $gwinfo = new $this->gatewayInformation;
        $gwinfo->sender = $data['sender'];
        $gwinfo->channel_type = $data['channel_type'];
        $gwinfo->service_provider = $data['service_provider'];
        $gwinfo->contents = $data['contents'];
        $gwinfo->created_by = $data['created_by'];
        $gwinfo->save();
        return $gwinfo;     
      }
    public function sendSmstextLocal($data)
    {
        $apiKey = env('SMS_TEXTLOCAL_KEY');
        $apiKey = urlencode( $apiKey);
        $number = $data['number'];
        $number = urlencode($number);
        $sender = $data['sender'];
        $sender = urlencode($sender);
       //$sender = urlencode('ODTKTS');
        $message = $data['message'];
        $message = rawurlencode($message);
        //$message = rawurlencode('PNR: 12345, Bus Details: gajanan, DOJ: 23-12-21, Route: cuttack, Dep: 12.30, Name: deepak, Gender: M, Seat: 1A, Fare: 230, Conductor Mob: 9987563412 - OD RPBOA');
        $route_no = 4; 
        $response_type = "json"; 
        $data = array('apikey' => $apiKey, 'numbers' => $number, "sender" => $sender, "message" => $message);
        $textLocalUrl = env('TEXT_LOCAL_SMS_URL');
        $ch = curl_init($textLocalUrl);     
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
            return $response;

    }
   

    public function sendSmsIndiaHub($data)
    {
        // parse the given URL
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
        die('Only HTTP request are supported !');
        }
        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];
        // open a socket connection on port 80
        $fp = fsockopen($host, 8000);
        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Referer: $referer\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: ". strlen($data) ."
        \r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        $result = "";
        while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);
        }
        // close the socket connection:
        fclose($fp);
        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);
        $header = isset($result[0]) ? $result[0] : ”;
        $content = isset($result[1]) ? $result[1] : ”;
        // return as array:
        //return array($header, $content);
        $data = array(
            'user' => "user",
            'password' => "pwd",
            'msisdn' => "919898123456",
            'sid' => "API",
            'msg' => "Test Message from API",
            'fl' =>"0",
        );
        $url = env('TEXT_SMS_INDIA_HUB_URL');
        list($header, $content) = PostRequest($url,$data);
    }
    
    public function sendSms($data) {
        $SmsGW = $data['smsprovider'];
        if($SmsGW=='textLocal'){

            //$apiKey = config('services.textlocal.key');
            //$apiKey = env('SMS_TEXTLOCAL_KEY'); 
            // $textLocalUrl = env('TEXT_LOCAL_SMS_URL','null');
            // $textLocalUrl = config('services.textlocal.url');

            $apiKey = urlencode('aCFowBsUJ8k-KB0egbyZ1Af6IAgX9Gvux2WBp6w2uP');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            $sender = urlencode($data['sender']);
            $otp = $data['otp'];
            $name = $data['name'];
            $message = $data['message'];
            $message = str_replace("<otp>",$otp,$message);
            $message = str_replace("<name>",$name,$message);
            $message = rawurlencode($message);
            $response_type = "json"; 
            $data = array('apikey' => $apiKey, 'numbers' => $receiver, "sender" => $sender, "message" => $message);
            $textLocalUrl = 'https://api.textlocal.in/send/';   

            // $ch = curl_init($textLocalUrl);   
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // $response = json_decode($response);
             
            // return $response;
            $msgId = $response->messages[0]->id;
            // return $msgId;
            //$curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $err = curl_error($ch);
            
            // if ($err) { 
            //     return "cURL Error #:" . $err;
            // } 
            $messageStatus = $this->smsDeliveryStatus($msgId);
            return $messageStatus;

        }elseif($SmsGW=='IndiaHUB'){
                $IndiaHubApiKey = urlencode('0Z6jDmBiAE2YBcD9kD4hVg');
                $otp = $data['otp'];
                // $IndiaHubApiKey = urlencode( $IndiaHubApiKey);
                // //$channel = 'transactional';
                // //$route =  '4';
                // //$dcs = '0';
                // //$flashsms = '0';
                // $smsIndiaUrl = 'http://cloud.smsindiahub.in/vendorsms/pushsms.aspx';
                // $receiver = urlencode($data['phone']);
                // $sender_id = urlencode($data['sender']);
                // $name = $data['name'];
                // $message = $data['message'];
                // $message = str_replace("<otp>",$otp,$message);
                // $message = rawurlencode($message);
    
                // $api = "$smsIndiaUrl?APIKey=".$IndiaHubApiKey."&sid=".$sender_id."&msg=".$message."&msisdn=".$receiver."&fl=0&gwid=2";
    
                // $response = file_get_contents($api);
                //return $response;

        }
      }

      public function smsDeliveryStatus($request)  
      {
        $apiKey = config('services.textlocal.key');
        $textLocalUrl = config('services.textlocal.url_msg');
        $ch = curl_init($textLocalUrl);
        // return $ch;
        // $arrs = $request->messages;
        // return $arrs;
        // foreach($arrs as $arr){
        //     $msgId = $arr[0]->id;
        //     return $msgId;
        // }
        // $msgId = $arr[0]->id;
        $msgId = $request->messages[0]['id'];
        $response = 'D';
        //$apiKey = urlencode('aCFowBsUJ8k-KB0egbyZ1Af6IAgX9Gvux2WBp6w2uP');
        $data = array('apikey' => $apiKey, 'message_id' => $msgId);
        //$ch = curl_init('https://api.textlocal.in/status_message/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        return $response;
        // for($i=0;$i<20;$i++){
        //     $response = curl_exec($ch);
        //     if (str_contains($response, 'D')) { 
        //         return $response->message->status;
        //     }
        //     sleep(3);
        // }
        curl_close($ch);
        $response = json_decode($response);
        $response = $response->message->status;
        return $response;

      }


      public function sendEmail($data) {

        $email = new \SendGrid\Mail\Mail();
        $email->sender = $data['sender'];
        $email->receiver = $data['receiver'];
        $email->contents = $data['contents'];
        $email->channel_type = $data['channel_type'];
        $email->acknowledgement = $data['acknowledgement'];

        // $email->setFrom = $request['setFrom'];
        // $email->setSubject = $request['setSubject'];
        // $email->addTo = $request['addTo'];
        // $email->addContent = $request['addContent'];
        // $email->addContent(
        //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
       // );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $email->save();
        return $email;

      }

      public function makePayment(Request $request)
    {   
        // $payment = new CustomerPayment;
        // $payment->sender = $request['sender'];
        // $payment->amount = $request['amount'];
        // $payment->contents = $request['contents'];
        // $payment->acknowledgement = $request['acknowledgement'];
        // try {
        //     $payment->save();
        //     return $this->successResponse($payment, Config::get('constants.RECORD_ADDED'), Response::HTTP_CREATED);
        // }
        // catch(Exception $e){
        //     return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
        // }	

        $input = $request->all();        
        $api = new CustomerPayment(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) 
        {
            try 
            {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
            } 
            catch (Exception $e) 
            {
                return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
            }            
        }
        return $this->successResponse($payment, Config::get('constants.PAYMENT_DONE'), Response::HTTP_CREATED);
    }

}
