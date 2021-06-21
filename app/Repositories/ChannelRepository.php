<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\CustomerNotification;
use Illuminate\Support\Facades\Log;
class ChannelRepository
{
    protected $customerNotification;
    public function __construct(CustomerNotification $customerNotification)
    {
        $this->customerNotification = $customerNotification; 
    }   
    public function sendSmstextLocal($data)
    {
        $apiKey = env('SMS_TEXTLOCAL_KEY');
        $apiKey = urlencode( $apiKey);
        $number = $data['number'];
        $number = urlencode($number);
        $sender = $data['sender'];
        $sender = urlencode($sender);
        $message = $data['message'];
        $message = rawurlencode($message);
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'number' => $number, "sender" => $sender, "message" => $message);
    
        // Send the POST request with cURL
        
        $textLocalUrl = env('TEXT_LOCAL_SMS_URL');
        $ch = curl_init($textLocalUrl); 
        //$ch = curl_init('https://api.textlocal.in/send/');      
        curl_setopt($ch, CURLOPT_POST, true);      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
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
        if($data['smsprovider']='textLocal') 
        $response = $this->sendSmstextLocal($data);
        else
        $this->sendSmsIndiaHub($data);
        $sms = new $this->customerNotification;
        $sms->sender = $data['sender'];
        $sms->receiver = $data['receiver'];
        $sms->contents = $data['contents'];
        $sms->channel_type = $data['channel_type'];
        $sms->acknowledgement = $response;
        $sms->save();
        return $sms;     
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
