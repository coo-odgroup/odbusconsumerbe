<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\GatewayInformation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailTicketJob;
use App\Jobs\SendAdminEmailTicketJob;
use App\Jobs\SendEmailTicketCancelJob;
use App\Jobs\SendAdminEmailTicketCancelJob;
use App\Mail\SendEmailOTP;
use Razorpay\Api\Api;
use App\Models\CustomerPayment;
use App\Models\ManageSms;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;
use App\Models\Bus;
use App\Models\Credentials;
use App\Models\AgentWallet;
use App\Models\AgentCommission;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\BusContacts;
use App\Models\Location;
use App\Models\TicketPrice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
Use hash_hmac;
use Razorpay\Api\Errors\SignatureVerificationError;

class ChannelRepository
{
    protected $gatewayInformation;
    protected $users;
    protected $customerPayment;
    protected $booking;
    protected $bookingDetail;
    protected $busSeats;
    protected $credentials;
    protected $manageSms;

    public function __construct(GatewayInformation $gatewayInformation,Users $users,CustomerPayment $customerPayment,Booking $booking,BusSeats $busSeats,Credentials $credentials,BookingDetail $bookingDetail,ManageSms $manageSms)
    {
        $this->gatewayInformation = $gatewayInformation; 
        $this->users = $users;
        $this->customerPayment = $customerPayment;
        $this->booking = $booking;
        $this->busSeats = $busSeats;
        $this->credentials = $credentials;
        $this->bookingDetail = $bookingDetail;
        $this->manageSms = $manageSms;
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
            //$apiKey = config('services.sms.textlocal.key');
            $apiKey = $this->credentials->first()->sms_textlocal_key;
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

        }elseif($SmsGW=='indiaHub'){
                $IndiaHubApiKey = config('services.sms.indiaHub.key');
                $otp = $data['otp'];
                $channel = 'transactional';
                //$route =  '4';
                //$dcs = '0';
                //$flashsms = '0';
                $smsIndiaUrl = 'http://cloud.smsindiahub.in/vendorsms/pushsms.aspx';
                $receiver = $data['phone'];
                $senderId = config('services.sms.indiaHub.senderid');
                $name = $data['name'];
                $message = config('services.sms.indiaHub.message');
                $message = str_replace("<otp>",$otp,$message);
                $message = str_replace("<name>",$name,$message);
                $msg = urlencode($message);
                $api = "$smsIndiaUrl?APIKey=".$IndiaHubApiKey."&sid=".$senderId."&msg=".$msg."&msisdn=".$receiver."&fl=0&gwid=2";
                $response = file_get_contents($api);
                //return $response;

        }
      }

      public function sendSmsAgent($data, $otp) {

        $SmsGW = config('services.sms.otpservice');
        if($SmsGW =='textLocal'){

            //Environment Variables
            //$apiKey = config('services.sms.textlocal.key');
            $apiKey = $this->credentials->first()->sms_textlocal_key;
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.msgAgent');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            //$name = $data['name'];
            $message = str_replace("<otp>",$otp,$message);
            //$message = str_replace("<name>",$name,$message);
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
            //$msgId = $response->messages[0]->id;  // Store msg id in DB
            //session(['msgId'=> $msgId]);

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
      public function sendSmsTicket($payable_amount,$data, $pnr) {
        $collection = collect($data['seat_no']);
        $seatList = $collection->implode(',');
        //$seatList = implode(",",$data['seat_no']);
        $nameList = "";
        $genderList ="";
        $passengerDetails = $data['passengerDetails'];
        $i = 0;
        $m = 0;
        $f = 0;
        $O = 0;
        //$nameList = $passengerDetails[0]->passenger_name;
        foreach($passengerDetails as $pDetail){
            if($i==0){
              $nameList = "{$nameList},{$pDetail['passenger_name']}";
            }
           
            $i++;
            switch($pDetail['passenger_gender']){
              case("M"):
                $m++;
              break;
              case("F"):
                $f++;
              break;
              case("O"):
                $O++;
              break;
            }
        } 
        
        // if($m==0){
        //   $genderList = substr($genderList,3);
        // }
        // if($f==0){
        //   $genderList = substr($genderList,0,-3);
        // }

        if($m>0 && $f>0 && $O > 0){
          $genderList = "{$m}M/{$f}F/{$O}O";
        }

        else if($m>0 && $f>0 && $O == 0){
          $genderList = "{$m}M/{$f}F";
        }

        else if($m>0 && $f==0 && $O > 0){
          $genderList = "{$m}M/{$O}O";
        }

        else if($m==0 && $f>0 && $O > 0){
          $genderList = "{$f}F/{$O}O";
        }

        else if($m>0 && $f==0 && $O == 0){
          $genderList = "{$m}M";
        }

        else if($m==0 && $f>0 && $O == 0){
          $genderList = "{$f}F";
        }

        else if($m==0 && $f==0 && $O > 0){
          $genderList = "{$O}O";
        }

        if(count($passengerDetails) > 1){
          $restNo = count($passengerDetails) -1 ;

          $nameList = "{$nameList}+{$restNo}"; 

        }
       
        $nameList = substr($nameList,1);
        //$genderList = substr($genderList,1);
        $busDetails = $data['busname'].'-'.$data['busNumber'];
        $SmsGW = config('services.sms.otpservice');

        //$payable_amount= $data['payable_amount'];

        if(isset($data['customer_comission'])){
          $payable_amount= $payable_amount + $data['customer_comission'];
        }

        if($SmsGW =='textLocal'){

            //Environment Variables
            //$apiKey = config('services.sms.textlocal.key');
            $apiKey = $this->credentials->first()->sms_textlocal_key;
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.msgTicket');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);/////////
            //$message = str_replace("<PNR>",$data['PNR'],$message);
            $message = str_replace("<PNR>",$pnr,$message);
            $message = str_replace("<busdetails>",$busDetails,$message);
            $message = str_replace("<DOJ>",$data['journeydate'],$message);
            $message = str_replace("<routedetails>",$data['routedetails'],$message);
            $message = str_replace("<dep>",$data['departureTime'],$message);
            $message = str_replace("<name>",$nameList,$message);
            $message = str_replace("<gender>",$genderList,$message);
            $message = str_replace("<seat>",$seatList,$message);
            $message = str_replace("<fare>",$payable_amount,$message);
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
      public function sendSmsCMO($payable_amount,$data, $pnr, $contact_number) {

        $collection = collect($data['seat_no']);
        $seatList = $collection->implode(',');
        //$seatList = implode(",",$data['seat_no']);
        $nameList = "";
        $genderList ="";
        $passengerDetails = $data['passengerDetails'];
        $i = 0;
        $m = 0;
        $f = 0;
        $O = 0;

        foreach($passengerDetails as $pDetail){
          if($i==0){
            $nameList = "{$nameList},{$pDetail['passenger_name']}";
          }
         
          $i++;
          switch($pDetail['passenger_gender']){
            case("M"):
              $m++;
            break;
            case("F"):
              $f++;
            break;
            case("O"):
              $O++;
            break;
          }
      } 
      
      if($m>0 && $f>0 && $O > 0){
        $genderList = "{$m}M/{$f}F/{$O}O";
      }
      
      else if($m>0 && $f>0 && $O == 0){
        $genderList = "{$m}M/{$f}F";
      }
      
      else if($m>0 && $f==0 && $O > 0){
        $genderList = "{$m}M/{$O}O";
      }
      
      else if($m==0 && $f>0 && $O > 0){
        $genderList = "{$f}F/{$O}O";
      }
      
      else if($m>0 && $f==0 && $O == 0){
        $genderList = "{$m}M";
      }
      
      else if($m==0 && $f>0 && $O == 0){
        $genderList = "{$f}F";
      }
      
      else if($m==0 && $f==0 && $O > 0){
        $genderList = "{$O}O";
      } 
      
      
      if(count($passengerDetails) > 1){
        $restNo = count($passengerDetails) -1 ;
      
        $nameList = "{$nameList}+{$restNo}";  
      }
      
      $nameList = substr($nameList,1);

        if(isset($data['customer_comission'])){
          $payable_amount= $payable_amount + $data['customer_comission'];
        }
   
        // foreach($passengerDetails as $pDetail){
        //     $nameList = "{$nameList},{$pDetail['passenger_name']}";
        //     $genderList = "{$genderList},{$pDetail['passenger_gender']}";
        // } 

        //$genderList = substr($genderList,1);
        $busDetails = $data['busname'].'-'.$data['busNumber'];
        $SmsGW = config('services.sms.otpservice');
        if($SmsGW =='textLocal'){

            //Environment Variables
            //$apiKey = config('services.sms.textlocal.key');
            $apiKey = $this->credentials->first()->sms_textlocal_key;
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.msgTicketCMO');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($contact_number); //$contact_number
            //$message = str_replace("<PNR>",$data['PNR'],$message);
            $message = str_replace("<PNR>",$pnr,$message);
            $message = str_replace("<busdetails>",$busDetails,$message);
            $message = str_replace("<DOJ>",$data['journeydate'],$message);
            $message = str_replace("<routedetails>",$data['routedetails'],$message);
            $message = str_replace("<dep>",$data['departureTime'],$message);
            $message = str_replace("<name>",$nameList,$message);
            $message = str_replace("<gender>",$genderList,$message);
            $message = str_replace("<seat>",$seatList,$message);
            $message = str_replace("<fare>",$payable_amount,$message);
            $message = str_replace("<contactmob>",$data['phone'],$message);
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

        }
      }
      public function sendSmsTicketCancelCMO($data,$contact_number) {
      
        $seatList = implode(",",$data['seat']);
        $doj = $data['doj'];
        $apiKey = $this->credentials->first()->sms_textlocal_key;
        $textLocalUrl = config('services.sms.textlocal.url_send');
        $sender = config('services.sms.textlocal.senderid');
        $message = config('services.sms.textlocal.cancelTicketCMO');
        $apiKey = urlencode( $apiKey);
        $receiver = urlencode($contact_number);
        $message = str_replace("<PNR>",$data['PNR'],$message);
        $message = str_replace("<busdetails>",$data['busdetails'],$message);
        $message = str_replace("<doj>",$doj,$message);
        $message = str_replace("<route>",$data['route'],$message);
        //$message = str_replace("<seat>",$data['seat'],$message);
        $message = str_replace("<seat>",$seatList,$message);
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
        //$msgId = $response->messages[0]->id;  // Store msg id in DB
        session(['msgId'=> $msgId]);

  }
      public function sendSmsTicketCancel($data) {
      
            $seatList = implode(",",$data['seat']);
            $doj = $data['doj'];
            $apiKey = $this->credentials->first()->sms_textlocal_key;
            $textLocalUrl = config('services.sms.textlocal.url_send');
            $sender = config('services.sms.textlocal.senderid');
            $message = config('services.sms.textlocal.cancelTicket');
            $apiKey = urlencode( $apiKey);
            $receiver = urlencode($data['phone']);
            $message = str_replace("<PNR>",$data['PNR'],$message);
            $message = str_replace("<busdetails>",$data['busdetails'],$message);
            $message = str_replace("<doj>",$doj,$message);
            $message = str_replace("<route>",$data['route'],$message);
            //$message = str_replace("<seat>",$data['seat'],$message);
            $message = str_replace("<seat>",$seatList,$message);
            $message = str_replace("<fare>",$data['refundAmount'],$message);
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
            //$msgId = $response->messages[0]->id;  // Store msg id in DB
            session(['msgId'=> $msgId]);

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
        $to = $request['email'];
        $name = $request['name'];
        $email_otp = $otp;

        SendEmailJob::dispatch($to, $name, $email_otp);        //Old method

       // Mail::to($to)->send(new SendEmailOTP($name,$email_otp)); //New Method

      }
 
      public function sendEmailTicket($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request, $pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount) {
        //$email_pnr = $pnr;
        //$data =  $request->all();
        //SendEmailTicketJob::dispatch($data, $email_pnr);
        SendEmailTicketJob::dispatch($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request, $pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount);
      }

      public function sendAdminEmailTicket($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request, $pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount) {
        
        SendAdminEmailTicketJob::dispatch($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request, $pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount);
      }

      public function sendEmailTicketCancel($request) {

        SendEmailTicketCancelJob::dispatch($request);
      }

      public function sendAdminEmailTicketCancel($request) {

        SendAdminEmailTicketCancelJob::dispatch($request);
      }

      public function getBookingRecord($transationId){
        return $this->booking->with('users')->where('transaction_id', $transationId)->get();
      }

      public function getBookingData($busId,$transationId){
       
          return $this->booking->with(["bus" => function($bs){
                        $bs->with('cancellationslabs.cancellationSlabInfo');
                      } ] )
                     ->where('bus_id', $busId)
                     ->where('transaction_id', $transationId)->get();
      }

      public function getRazorpayKey(){
          return $this->credentials->first()->razorpay_key;
      }

      public function getRazorpaySecret(){
        return $this->credentials->first()->razorpay_secret;
    }


      public function CreateCustomPayment($receiptId, $amount ,$name, $bookingId){

        $key = $this->getRazorpayKey();
        $secretKey = $this->getRazorpaySecret();
        
        $api = new Api($key, $secretKey);   
        $order = $api->order->create(array('receipt' => $receiptId, 'amount' => $amount * 100 , 'currency' => 'INR')); 

        // Creates customer payment 
        $orderId = $order['id']; 
        $user_pay = new $this->customerPayment();
        $user_pay->name = $name;
        $user_pay->booking_id = $bookingId;
        $user_pay->amount = $amount;
        $user_pay->order_id = $orderId;
         $user_pay->save();

         return $orderId;

      }

  
      public function UpdateStatus($bookingId,$seatHold){
        $this->booking->where('id', $bookingId)->update(['status' => $seatHold]);
      }

      public function GetCustomerPaymentId($razorpay_order_id)
      {
          return $this->customerPayment->where('order_id', $razorpay_order_id)->pluck('id');
      }

      public function updateCustomerGST($update_customer_gst,$transationId){

        $this->booking->where('transaction_id', $transationId)->update($update_customer_gst);

      }


      public function UpdateCutsomerPaymentInfo($razorpay_order_id,$razorpay_signature,$razorpay_payment_id,$customerId,$paymentDone,$totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request,$bookingId,$booked,$bookedStatusFailed,$transationId,$pnr,$busId,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount){

        $key = $this->getRazorpayKey();
        $secretKey = $this->getRazorpaySecret();
        $SmsGW = config('services.sms.otpservice');
       
        $generated_signature = hash_hmac('sha256', $razorpay_order_id."|" .$razorpay_payment_id, $secretKey);

        $api = new Api($key, $secretKey);

        $payment = $api->payment->fetch($razorpay_payment_id);
        $paymentStatus = $payment->status;

        if ($generated_signature == $razorpay_signature && $paymentStatus == 'captured') { //captured(live version) , authorized (test version)
            $this->customerPayment->where('id', $customerId)
                                ->update([
                                    'razorpay_id' => $razorpay_payment_id,
                                    'razorpay_signature' => $razorpay_signature,
                                    'payment_done' => $paymentDone
                                ]);
            if($request['phone']){
  
                $sendsms = $this->sendSmsTicket($payable_amount,$request,$pnr); 
      
                 $msgId = $sendsms->messages[0]->id;
                 $status = $sendsms->status;
                 $from = $sendsms->message->sender;
                 $to = $sendsms->messages[0]->recipient;
                 //$to = substr($to, 2); 
                 $contents = $sendsms->message->content;
                 $response = collect($sendsms);
                //dd($response);
                /// save sms related things in manage_sms table///////////////
        
                $sms = new $this->manageSms();
                $sms->pnr = $pnr;
                $sms->booking_id = $bookingId;
                $sms->sms_engine = $SmsGW;
                $sms->status = $status;
                $sms->from = $from;
                $sms->to = $to;
                $sms->contents = $contents;
                $sms->response = $response;
                $sms->message_id = $msgId;
                $sms->save();
            } 
            if($request['email']){
                $sendEmailTicket = $this->sendEmailTicket($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request,$pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount); 
            }

         /////////////////send email to odbus admin////////

        $this->sendAdminEmailTicket($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request,$pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount);
         
         
      ///////////////////CMO SMS/////////////////////////////////////////////////
        $busContactDetails = BusContacts::where('bus_id',$busId)
                                          ->where('status','1')
                                          ->where('booking_sms_send','1')
                                          ->get('phone');
        if($busContactDetails->isNotEmpty()){
            $contact_number = collect($busContactDetails)->implode('phone',',');
            $sendSmsCMO = $this->sendSmsCMO($payable_amount,$request, $pnr, $contact_number);

            $msgId = $sendSmsCMO->messages[0]->id;
            $status = $sendSmsCMO->status;
            $from = $sendSmsCMO->message->sender;
            $to = collect($sendSmsCMO->messages)->pluck('recipient');
            $contents = $sendSmsCMO->message->content;
            $response = collect($sendSmsCMO);

            /// save sms related things in manage_sms table///////////////
        
            $sms = new $this->manageSms();
            $sms->pnr = $pnr;
            $sms->booking_id = $bookingId;
            $sms->sms_engine = $SmsGW;
            $sms->status = $status;
            $sms->from = $from;
            $sms->to = $to;
            $sms->contents = $contents;
            $sms->response = $response;
            $sms->message_id = $msgId;
            $sms->save();
            //return $sms;
        }
      
        //Update  Booking Ticket Status in booking Change status to 1(Booked)  

        $this->booking->where('id', $bookingId)->update(['status' => $booked,'payable_amount' => $payable_amount ]);
        $booking = $this->booking->find($bookingId);
        $booking->bookingDetail()->where('booking_id', $bookingId)->update(array('status' => $booked));

            return "Payment Done";
        }
        else{ 
            $this->booking->where('id', $bookingId)
                        ->where('transaction_id', $transationId)
                        ->update(['status' => $bookedStatusFailed,'status' => $bookedStatusFailed]); 
            return "Payment Failed"; 
        }
      }

      public function CreateAgentPayment($agentId,$agentName,$amount ,$name,$bookingId,$transactionId){
        $walletBalance =  $walletBalance = AgentWallet::where('user_id',$agentId)->orderBy('id','DESC')->where("status",1)->limit(1)->get();
        //AgentWallet::where('user_id',$agentId)->where('status',1)->latest()->first()->balance;
        $agetWallet = new AgentWallet();
        $agetWallet->transaction_id = $transactionId;
        $agetWallet->amount = $amount;
        $agetWallet->transaction_type = 'd';
        $agetWallet->booking_id = $bookingId;
        $agetWallet->balance = $walletBalance [0]->balance - $amount;
        $agetWallet->user_id = $agentId;
        $agetWallet->created_by = $agentName;
        $agetWallet->status = 1;
        $agetWallet->save();

        $newBalance = $walletBalance [0]->balance - $amount;
        $notification = new Notification;
        $notification->notification_heading = "New Balance is Rs.$newBalance after booking for Rs.$amount";
        $notification->notification_details = "New Balance is Rs.$newBalance after booking for Rs.$amount";
        $notification->created_by = 'Agent';
        $notification->save();
       
        $userNotification = new UserNotification();
        $userNotification->user_id = $agentId;
        $userNotification->created_by= "Agent"; 
        $notification->userNotification()->save($userNotification);

      }

      public function FetchAgentBookedSeats($agentId,$agentName,$seatIds,$bookingId,$seatHold,$appliedComission){
        $seatRecords =  Booking::with('bookingDetail')->where('user_id',$agentId)
                                                      ->where('status', '1')->get();
        $collection = collect($seatRecords);
        $bookedSeatCount = 0;
        foreach($collection as $record) {
            $count =  $record->bookingDetail->count();
            $bookedSeatCount = $bookedSeatCount + $count;
        }
        $agentComission = AgentCommission::get();
        $currentSeatCount = count($seatIds);
        $totalSeatCount = $bookedSeatCount+$currentSeatCount;

        foreach($agentComission as $comission){
          $rangeFrom = $comission->range_from;
          $rangeTo = $comission->range_to;
          if($totalSeatCount >= $rangeFrom && $totalSeatCount <= $rangeTo){
              $comissionPerSeat = $comission->comission_per_seat;//comission per seat getting from odbus
            break;
          }else{
              $comissionPerSeat = 0;
          }    
        }
        $totalAgentComission =  $currentSeatCount * $comissionPerSeat;
        $tds = $totalAgentComission*.05;                                             ///5% TDS Hard Coded.
        $afterTdsComission = $totalAgentComission - $tds;

        $this->booking->where('id', $bookingId)->update(['customer_comission' => $appliedComission,
        'status' => $seatHold, 'agent_commission' => $totalAgentComission, 'tds' => $tds,'with_tds_commission' => $afterTdsComission]);

        $walletBalance = AgentWallet::where('user_id',$agentId)->latest()->first()->balance;
        $transactionId = date('YmdHis') . gettimeofday()['usec'];
        $agetWallet = new AgentWallet();
        $agetWallet->transaction_id = $transactionId;
        $agetWallet->amount = $afterTdsComission;
        $agetWallet->type = 'Commission';
        $agetWallet->booking_id = $bookingId;
        $agetWallet->transaction_type = 'c';
        $agetWallet->balance = $walletBalance + $afterTdsComission;
        $agetWallet->user_id = $agentId;
        $agetWallet->created_by = $agentName;
        $agetWallet->status = 1;
        $agetWallet->save();
        //return $agetWallet;

        $newBalance = $walletBalance + $afterTdsComission;
        $notification = new Notification;
        $notification->notification_heading = "New Balance is Rs.$newBalance after getting Comission of Rs.$afterTdsComission";
        $notification->notification_details = "New Balance is Rs.$newBalance after getting Comission of Rs.$afterTdsComission";
        $notification->created_by = 'Agent';
        $notification->save();
       
        $userNotification = new UserNotification();
        $userNotification->user_id = $agentId;
        $userNotification->created_by= "Agent"; 
        $notification->userNotification()->save($userNotification);
        return $notification;
      }
      public function UpdateAgentPaymentInfo($paymentDone,$totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request,$bookingId,$bookedStatusFailed,$transationId,$pnr,$busId,$booked,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount)
      {  
        if($request['phone']){

          $sendsms = $this->sendSmsTicket($payable_amount,$request,$pnr);
        } 
        if($request['email']){
            $sendEmailTicket = $this->sendEmailTicket($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request,$pnr,$cancellationslabs,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount); 
        } 

         ///////////////////CMO SMS/////////////////////////////////////////////////
         $busContactDetails = BusContacts::where('bus_id',$busId)
         ->where('status','1')
         ->where('booking_sms_send','1')
         ->get('phone');

          if($busContactDetails->isNotEmpty()){
          $contact_number = collect($busContactDetails)->implode('phone',',');
          $this->sendSmsCMO($payable_amount,$request, $pnr, $contact_number);
          }


        $this->booking->where('id', $bookingId)->update(['status' => $booked,'payable_amount' => $payable_amount ]);
        $booking = $this->booking->find($bookingId);
        $booking->bookingDetail()->where('booking_id', $bookingId)->update(array('status' => $booked));
        return "Payment Done";
       
        $this->booking->where('id', $bookingId)
                      ->where('transaction_id', $transationId)
                      ->update(['status' => $bookedStatusFailed,'status' => $bookedStatusFailed]); 
        return "Payment Failed"; 
      }
    ////////////resend SmsEmail icket///////////////////////////
    public function resendTicket($request)
    {
      $pnr = $request['pnr_no'];
      $action = $request['action'];

      $bookingDetails = $this->booking->where('pnr', $pnr)
                                          ->with('bookingDetail')
                                          ->get();
      $phone = Users::where('id',$bookingDetails[0]->users_id)->first()->phone;
      $busname = $bookingDetails[0]->bus->name;
      $busNumber = $bookingDetails[0]->bus->bus_number;
      $journeydate = $bookingDetails[0]->journey_dt;
      $srcName = Location::where('id',$bookingDetails[0]->source_id)->first()->name;
      $destName = Location::where('id',$bookingDetails[0]->destination_id)->first()->name;
      $routedetails = $srcName.'-'.$destName;
      $departureTime = TicketPrice::where('bus_id',$bookingDetails[0]->bus_id)->first()->dep_time;
      $departureTime = date("H:i:s",strtotime($departureTime));

      if($bookingDetails[0]->payable_amount == 0.00){
        $payable_amount = $bookingDetails[0]->total_fare;
      }else{
        $payable_amount = $bookingDetails[0]->payable_amount;
      }

      $passengerDetails = $bookingDetails[0]->bookingDetail;
      $conductor_number = BusContacts::where('bus_id',$bookingDetails[0]->bus_id)->where('type','2')  ->first()->phone;
      $busSeatsIds = $bookingDetails[0]->bookingDetail->pluck('bus_seats_id');
      $busSeatsDetails = BusSeats::whereIn('id',$busSeatsIds)->with('seats')->get();
      $seat_no = $busSeatsDetails->pluck('seats.seatText');
      
      $data = array(
          "seat_no" => $seat_no,
          "passengerDetails" => $passengerDetails, 
          "busname" => $busname,
          "busNumber" => $busNumber,
          "phone" => $phone,
          "journeydate" => $journeydate,
          "routedetails" => $routedetails,
          "departureTime" => $departureTime,
          "conductor_number" => $conductor_number,
      );
                                 
      if($action == "smsToCustomer"){
        
        $sendsms = $this->sendSmsTicket($payable_amount,$data,$pnr); 
        return "msg_sent";
      }
      if($action == "smsToConductor"){
        $contact_number = BusContacts::where('bus_id',$bookingDetails[0]->bus_id)
                                          ->where('status','1')
                                          ->where('booking_sms_send','1')
                                          ->where('type','2')
                                          ->first()->phone;
        if(isset($contact_number)){
          $this->sendSmsCMO($payable_amount,$data, $pnr, $contact_number);
          return "msg_sent";
        }
      }
      if($action == "smsToManager"){
        $contact_number = BusContacts::where('bus_id',$bookingDetails[0]->bus_id)
                                          ->where('status','1')
                                          ->where('booking_sms_send','1')
                                          ->where('type','1')
                                          ->first()->phone;
        if(isset($contact_number)){
          $this->sendSmsCMO($payable_amount,$data, $pnr, $contact_number);
          return "msg_sent";
        }
      }
      if($action == "smsToOwner"){
        $contact_number = BusContacts::where('bus_id',$bookingDetails[0]->bus_id)
                                          ->where('status','1')
                                          ->where('booking_sms_send','1')
                                          ->where('type','0')
                                          ->first()->phone;
        if(isset($contact_number)){
          $this->sendSmsCMO($payable_amount,$data, $pnr, $contact_number);
          return "msg_sent";
        }
      }
      ////////testing pending////////////
      if($action == "emailToCustomer"){
        
        $sendemail = $this->sendEmailTicket(); 
        return "msg_sent";
      }
      if($action == "emailToAdmin"){
        
        $sendemail = $this->sendEmailTicket(); 
        return "msg_sent";
      }
    }
}
