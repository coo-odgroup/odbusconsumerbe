<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\CustomerNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class ChannelRepository
{
    protected $customerNotification;
    public function __construct(CustomerNotification $customerNotification)
    {
        $this->customerNotification = $customerNotification; 
    } 
    
    public function storeGWInfo($data) {
        $gwinfo = new $this->customerNotification;
        $gwinfo->sender = $data['sender'];
        $gwinfo->receiver = $data['receiver'];
        $gwinfo->contents = $data['contents'];
        $gwinfo->channel_type = $data['channel_type'];
        $gwinfo->acknowledgement = $data['acknowledgement'];
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
            $apiKey = config('services.textlocal.key');
            //$apiKey = env('SMS_TEXTLOCAL_KEY'); 
            //$apiKey = urlencode('aCFowBsUJ8k-KB0egbyZ1Af6IAgX9Gvux2WBp6w2uP');
            $otp = $data['otp'];
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            $sender = urlencode($data['sender']);
            $name = $data['name'];
            $message = $data['message'];
            $message = str_replace("<otp>",$otp,$message);
            $message = rawurlencode($message);
            $response_type = "json"; 
            $data = array('apikey' => $apiKey, 'numbers' => $receiver, "sender" => $sender, "message" => $message);
            //$textLocalUrl = 'https://api.textlocal.in/send/';
            //$textLocalUrl = env('TEXT_LOCAL_SMS_URL','null');
            $textLocalUrl = config('services.textlocal.url');
             $ch = curl_init($textLocalUrl);   
             return $ch;
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            return $response;
            $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);
            if ($err) {
                return "cURL Error #:" . $err;
            } 
        }elseif($SmsGW=='IndiaHUB'){
            return 'Inside India HUB';

        }
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
