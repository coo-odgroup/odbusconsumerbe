<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\GatewayInformation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailTicketJob;
use Razorpay\Api\Api;
use App\Models\CustomerPayment;
use App\Models\Booking;
Use hash_hmac;
use Razorpay\Api\Errors\SignatureVerificationError;

class ChannelRepository
{
    protected $gatewayInformation;
    protected $users;
    protected $customerPayment;
    protected $booking;

    public function __construct(GatewayInformation $gatewayInformation,Users $users,CustomerPayment $customerPayment,Booking $booking)
    {
        $this->gatewayInformation = $gatewayInformation; 
        $this->users = $users;
        $this->customerPayment = $customerPayment;
        $this->booking = $booking;
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
    
    public function sendSms($data, $otp) {
        $SmsGW = config('services.sms.otpservice');
        if($SmsGW =='textLocal'){

            //Environment Variables
            $apiKey = config('services.sms.textlocal.key');
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.message');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            $name = $data['name'];
            $message = str_replace("<otp>",$otp,$message);
            $message = str_replace("<name>",$name,$message);
            //return $message;
            $message = rawurlencode($message);
            $response_type = "json"; 
            $data = array('apikey' => $apiKey, 'numbers' => $receiver, "sender" => $sender, "message" => $message);
            

            $ch = curl_init($textLocalUrl);   
            curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
             
            // return $response;
            $msgId = $response->messages[0]->id;  // Store msg id in DB
            session(['msgId'=> $msgId]);

            // $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $err = curl_error($ch);
            
            // if ($err) { 
            //     return "cURL Error #:" . $err;
            // } 

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
      //public function sendSmsTicket($data){
      public function sendSmsTicket($data, $pnr) {

        $seatList = implode(",",$data['seat_id']);
        $nameList = "";
        $genderList ="";
        $passengerDetails = $data['passengerDetails'];
   
        foreach($passengerDetails as $pDetail){
            $nameList = "{$nameList},{$pDetail['passenger_name']}";
            $genderList = "{$genderList},{$pDetail['passenger_gender']}";
        } 
        $nameList = substr($nameList,1);
        $genderList = substr($genderList,1);
        $busDetails = $data['busname'].'-'.$data['busNumber'];
        $SmsGW = config('services.sms.otpservice');
        if($SmsGW =='textLocal'){

            //Environment Variables
            $apiKey = config('services.sms.textlocal.key');
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.msgTicket');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            //$message = str_replace("<PNR>",$data['PNR'],$message);
            $message = str_replace("<PNR>",$pnr,$message);
            $message = str_replace("<busdetails>",$busDetails,$message);
            $message = str_replace("<DOJ>",$data['journeydate'],$message);
            $message = str_replace("<routedetails>",$data['routedetails'],$message);
            $message = str_replace("<dep>",$data['departureTime'],$message);
            $message = str_replace("<name>",$nameList,$message);
            $message = str_replace("<gender>",$genderList,$message);
            $message = str_replace("<seat>",$seatList,$message);
            $message = str_replace("<fare>",$data['totalfare'],$message);
            $message = str_replace("<conmob>",$data['conductor_number'],$message);
            //return $message;
            $message = rawurlencode($message);
            $response_type = "json"; 
            $data = array('apikey' => $apiKey, 'numbers' => $receiver, "sender" => $sender, "message" => $message);
            

            $ch = curl_init($textLocalUrl);   
            curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt ($ch, CURLOPT_CAINFO, 'D:\ECOSYSTEM\PHP\extras\ssl'."/cacert.pem");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
             
            return $response;
            $msgId = $response->messages[0]->id;  // Store msg id in DB
            session(['msgId'=> $msgId]);

            // $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $err = curl_error($ch);
            
            // if ($err) { 
            //     return "cURL Error #:" . $err;
            // } 

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
        $phone = $request['phone'];
        $msgId = $this->users->where('phone', $phone)->pluck('msg_id'); 
        //return $msgId;
        $apiKey = config('services.sms.textlocal.key');
        $textLocalUrl = config('services.sms.textlocal.url_status');
        $msgTemplate = config('services.sms.textlocal.message');

        //return $textLocalUrl; 

        $ch = curl_init($textLocalUrl);
        //$msgId = $request->messages[0]['id'];
        
        $apiKey = urlencode($apiKey);
        $data = array('apikey' => $apiKey, 'message_id' => $msgId[0]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $statusresp = curl_exec($ch);

        curl_close($ch);
        $statusresp = json_decode($statusresp);
        $statusresp = $statusresp->message->status;

        if (str_contains($statusresp, 'D')) { 
                    return 'Message Delivered Status:'.$statusresp;
                }

      }


      public function sendEmail($request, $otp) {
        
        // $to = $request['receiver'];
        // $name = $request['name'];
        // $email_body = $request['message'];

        $to = $request['email'];
        $name = $request['name'];
        $email_otp = $otp;

        //$email_otp = $request['otp'];
        //$emailSubject = config('services.email.subject');
        //return $emailSubject;
        SendEmailJob::dispatch($to, $name, $email_otp);
       
      }

   
      public function sendEmailTicket($request, $pnr) {
        $email_pnr = $pnr;
        // $data = $request->only([
        //     'name','email','bookingdate','journeydate', 'boarding_point','dropping_point',
        //     'departureTime','arrivalTime','seat_id','busname','busNumber','bustype',
        //     'busTypeName','sittingType','conductor_number','totalfare','passengerDetails' ]); 
        $data =  $request->all();
        SendEmailTicketJob::dispatch($data, $email_pnr);
       
      }

      public function makePayment(Request $request)
    {   
        $transationId = $request['transaction_id'];
        $records = $this->booking->with('users')->where('transaction_id', $transationId)->get();
        foreach($records as $record){
            $name = $record->users->name;
        }
        $amount = $request['amount'];
        $receiptId = 'rcpt_'.$transationId;
        $key = config('services.razorpay.key');
        $secretKey = config('services.razorpay.secret');
        $api = new Api($key, $secretKey);
        $order = $api->order->create(array('receipt' => $receiptId, 'amount' => $amount * 100 , 'currency' => 'INR')); 

        // Creates payment booking
        $orderId = $order['id']; 
        $user_pay = new $this->customerPayment();
    
        $user_pay->name = $name;
        $user_pay->amount = $amount;
        $user_pay->order_id = $orderId;
        $user_pay->save();

        $data = array(
            'name' => $name,
            'amount' => $amount,
            'key' => $key,
            'razorpay_order_id' => $orderId   
        );
       return $data;
    }
    public function pay($request)
    {   
        $key = config('services.razorpay.key');
        $secretKey = config('services.razorpay.secret');
        $data = $request->all();
        $customerId = $this->customerPayment->where('order_id', $data['razorpay_order_id'])->pluck('id');
        $customerId = $customerId[0];

        $razorpay_signature = $data['razorpay_signature'];
        $razorpay_payment_id = $data['razorpay_payment_id'];
        $razorpay_order_id = $data['razorpay_order_id'];
        $transationId = $data['transaction_id'];
        $pnr = $this->booking->where('transaction_id', $transationId)->pluck('pnr')[0];

        $generated_signature = hash_hmac('sha256', $razorpay_order_id."|" .$razorpay_payment_id, $secretKey);

        if ($generated_signature == $data['razorpay_signature']) {
            
            $this->customerPayment->where('id', $customerId)->update(array('razorpay_id' => $razorpay_payment_id));
            $this->customerPayment->where('id', $customerId)->update(array('payment_done' => '1'));

            if($request['phone']){
                $sendsms = $this->sendSmsTicket($request,$pnr); 
                return "Payment Done";
            } 
            elseif($request['email']){
                $sendEmailTicket = $this->sendEmailTicket($request,$pnr);
                return "Payment Done";
            }
        }
        else{
            return "Payment Failed"; 
            }
        
    }

}
