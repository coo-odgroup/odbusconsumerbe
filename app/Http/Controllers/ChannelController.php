<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CustomerNotification;
use App\Models\CustomerPayment;

class ChannelController extends Controller
{
    use ApiResponser;
    public function __construct()
        {
        }
    public function sendSmstextLocal(Request $request)
    {
        $apiKey = env('SMS_TEXTLOCAL_KEY');
        $apiKey = urlencode( $apiKey);
        $number = $request['number'];
        $number = urlencode($number);
        $sender = $request['sender'];
        $sender = urlencode($sender);
        $message = $request['message'];
        $message = rawurlencode($message);
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'number' => $number, "sender" => $sender, "message" => $message);
    
        // Send the POST request with cURL
        
        $textLocalUrl = env('TEXT_LOCAL_SMS_URL');
        $ch = curl_init($textLocalUrl);       
        curl_setopt($ch, CURLOPT_POST, true);      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	
	// Process your response here
    return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }

    public function sendSmsIndiaHub(Request $request)
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
        return array($header, $content);
        $data = array(
            'user' => "user",
            'password' => "pwd",
            'msisdn' => "919898123456",
            'sid' => "API",
            'msg' => "Test Message from API",
            'fl' =>"0",
        );
        $url = "http://cloud.smsindiahub.in/vendorsms/pushsms.aspx";
        list($header, $content) = PostRequest($url,$data);
    
        // the url to post to "http://www.yourdomain.com/sms.php",
        // its your url
        
        //echo $content;
        return $this->successResponse($content,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
    public function testSMS(Request $request) 
    {
        return "Hello World";
    }
    public function sendSms(Request $request) {

        if($request['smsprovider']='textLocal') 
        $response =   $this->sendSmstextLocal($request);
        else
        $this->sendSmsIndiaHub($request);
        //$response =   $this->sendSmstextLocal($request);
        //return "xxxxxxxxxx";

        $sms = new CustomerNotification;
        $sms->sender = $request['sender'];
        $sms->receiver = $request['receiver'];
        $sms->contents = $request['contents'];
        $sms->channel_type = $request['channel_type'];
        $sms->acknowledgement = $response;
       
        
        try {
            $sms->save();
            return $this->successResponse($sms, Config::get('constants.RECORD_ADDED'), Response::HTTP_CREATED);
        }
        catch(Exception $e){
            return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
        }	
      }

      public function sendEmail(Request $request) {

        $email = new \SendGrid\Mail\Mail();
        $email->sender = $request['sender'];
        $email->receiver = $request['receiver'];
        $email->contents = $request['contents'];
        $email->channel_type = $request['channel_type'];
        $email->acknowledgement = $request['acknowledgement'];

        // $email->setFrom = $request['setFrom'];
        // $email->setSubject = $request['setSubject'];
        // $email->addTo = $request['addTo'];
        // $email->addContent = $request['addContent'];
        // $email->addContent(
        //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
       // );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            return $this->successResponse($response,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
        }
        catch(Exception $e){
            return $this->errorResponse($e->getMessage(),Response::HTTP_PARTIAL_CONTENT);
        }  
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
