<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\CustomerPayment;
use App\Models\BusType;
use App\Models\BusClass;
use App\Models\BusSeats;
use App\Models\BusContacts;
use App\Models\Seats;
use App\Models\TicketPrice;
use App\Jobs\SendEmailTicketJob;
use App\Models\Credentials;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use DateTime;


class BookingManageRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $seats;
    protected $bookingDetail;
    protected $busType;
    protected $busClass;
    protected $credentials;
    protected $customerPayment;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,
    BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail, Seats $seats,BusClass $busClass
    ,BusType $busType,Credentials $credentials,CustomerPayment $customerPayment)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->seats = $seats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
        $this->busType = $busType;
        $this->busClass = $busClass;
        $this->credentials = $credentials;
        $this->customerPayment = $customerPayment;
    }   
    
    public function getJourneyDetails($mobile,$pnr)
    { 

       return $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr);
            $u->with(["bus" => function($bs){
                $bs->with('BusType.busClass');
                $bs->with('BusSitting');
            }]); 
        }])->get();
       
    }

    public function GetLocationName($location_id){
        return $this->location->where('id',$location_id)->get();
    }

    public function getPassengerDetails($mobile,$pnr)
    { 

       return $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
                                                $u->where('booking.pnr', '=', $pnr);
                                                $u->with(["bookingDetail" => function($b){
                                                    $b->with(["busSeats" => function($s){
                                                        $s->with("seats");
                                                    } ]);
                                                } ]);
                                            }])->get();
       
    }

    public function getBookingDetails($mobile,$pnr)
    { 

      return $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
        $u->where('booking.pnr', '=', $pnr);            
        $u->with(["bus" => function($bs){
            $bs->with('BusType.busClass');
            $bs->with('BusSitting');                
            $bs->with('busContacts');
          } ] );           
        
        $u->with(["bookingDetail" => function($b){
            $b->with(["busSeats" => function($s){
                $s->with("seats");
              } ]);
        }]);
        
       }])->get();

    }

    public function emailSms($request)
    { 
      
     
      
        $b= $this->getBookingDetails($request);
              
         
      
      
        if($b && isset($b[0])){

            $b=$b[0];

            $seat_arr=[];
            $seat_no='';
          
            foreach($b->booking[0]->bookingDetail as $bd){
                array_push($seat_arr,$bd->busSeats->seats->seatText);              
              
            }            

            $body = [
                'name' => $b->name,
                'phone' => $b->phone,
                'email' => $b->email,
                'pnr' => $b->booking[0]->pnr,
                'bookingdate'=> $b->booking[0]->created_at,
                'journeydate' => $b->booking[0]->journey_dt ,
                'boarding_point'=> $b->booking[0]->boarding_point,
                'dropping_point' => $b->booking[0]->dropping_point,
                'departureTime'=> $b->booking[0]->boarding_time,
                'arrivalTime'=> $b->booking[0]->dropping_time,
                'seat_no' => $seat_arr,
                'busname'=> $b->booking[0]->bus->name,
                'source'=> $b->booking[0]->source[0]->name,
                'destination'=> $b->booking[0]->destination[0]->name,
                'busNumber'=> $b->booking[0]->bus->bus_number,
                'bustype' => $b->booking[0]->bus->busType->name,
                'busTypeName' => $b->booking[0]->bus->busType->busClass->class_name,
                'sittingType' => $b->booking[0]->bus->busSitting->name, 
                'conductor_number'=> $b->booking[0]->bus->busContacts->phone,
                'passengerDetails' => $b->booking[0]->bookingDetail ,
                'totalfare'=> $b->booking[0]->total_fare,
                'discount'=> $b->booking[0]->coupon_discount,
                'payable_amount'=> $b->booking[0]->payable_amount,
                'odbus_gst'=> $b->booking[0]->odbus_gst_amount,
                'odbus_charges'=> $b->booking[0]->odbus_charges,
                'owner_fare'=> $b->booking[0]->owner_fare,
                'routedetails' => $b->booking[0]->source[0]->name."-".$b->booking[0]->destination[0]->name
                
            ];
          
          
           
          
            if($b->email != ''){
              
                 $sendEmailTicket = $this->sendEmailTicket($body,$b->booking[0]->pnr); 
            }

            if($b->phone != ''){
                 $sendEmailTicket = $this->sendSmsTicket($body,$b->booking[0]->pnr); 
            }

            return "Email & SMS has been sent to ".$b->email." & ".$b->phone;

        }else{

            return "Invalid request";   

        }

    }


    public function cancelTicketInfo($request){


        $pnr = $request['pnr'];
        $mobile = $request['mobile'];

        $booking_detail  = $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr); 
            $u->with("customerPayment");           
            $u->with(["bus" => function($bs){
                $bs->with('cancellationslabs.cancellationSlabInfo');
              } ] );          
            
            $u->with(["bookingDetail" => function($b){
                $b->with(["busSeats" => function($s){
                    $s->with("seats");
                  } ]);
            } ]);

            
        }])->get();

      
        if(isset($booking_detail[0])){          

             if(isset($booking_detail[0]->booking[0]) && !empty($booking_detail[0]->booking[0])){

                
                $jDate =$booking_detail[0]->booking[0]->journey_dt;
                $jDate = date("d-m-Y", strtotime($jDate));
                $boardTime =$booking_detail[0]->booking[0]->boarding_time; 

                $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
                $current_date_time = Carbon::now()->toDateTimeString(); 
                $bookingDate = new DateTime($combinedDT);
                $cancelDate = new DateTime($current_date_time);
                $interval = $bookingDate->diff($cancelDate);
                 $interval = ($interval->format("%a") * 24) + $interval->format(" %h");

                 if($interval < 12) {
                    return 'Cancellation is not allowed';                    
                }

                 $razorpay_payment_id=$booking_detail[0]->booking[0]->customerPayment->razorpay_id;


                 $cancelPolicies = $booking_detail[0]->booking[0]->bus->cancellationslabs->cancellationSlabInfo;
                foreach($cancelPolicies as $cancelPolicy){
                    $duration = $cancelPolicy->duration;
                    $deduction = $cancelPolicy->deduction;
                    $duration = explode("-", $duration, 2);
                    $max= $duration[1];
                    $min= $duration[0];
    
                    if( $interval > 240){
                        $deduction = 10;//minimum deduction
                        $refund =  $this->refundPolicy($deduction,$razorpay_payment_id);
                        $refundAmt =  ($refund['refundAmount']/100);
                        $paidAmt =  ($refund['paidAmount']/100);

                        $emailData['refundAmount'] = $refundAmt;
                        $emailData['deductionPercentage'] = $deduction."%";
                        $emailData['deductAmount'] =$paidAmt-$refundAmt;
                        $emailData['totalfare'] = $paidAmt;

                        if($booking_detail[0]->booking[0]->status==2){
                            $emailData['cancel_status'] = false;
                        }else{
                            $emailData['cancel_status'] = true;
                        }
                       

                        return $emailData;
    
                    }elseif($min < $interval && $interval < $max){ 

                        $refund =  $this->refundPolicy($deduction,$razorpay_payment_id);

                        $refundAmt =  ($refund['refundAmount']/100);
                        $paidAmt =  ($refund['paidAmount']/100);

                        $emailData['refundAmount'] = $refundAmt;
                        $emailData['deductionPercentage'] = $deduction."%";
                        $emailData['deductAmount'] =$paidAmt-$refundAmt;
                        $emailData['totalfare'] = $paidAmt;
                        
                        if($booking_detail[0]->booking[0]->status==2){
                            $emailData['cancel_status'] = false;
                        }else{
                            $emailData['cancel_status'] = true;
                        }

                        return $emailData;
                       
                    }
                }
                                 
            }
            
            else{                
                return "PNR doesn't match";                
           }
       }
       
       else{            
           return "Mobile no doesn't match";            
       }

        return $booking_detail;
        
    }


    public function refundPolicy($percentage,$razorpay_payment_id){

        $key = $this->credentials->first()->razorpay_key;
        $secretKey = $this->credentials->first()->razorpay_secret;
        
        $api = new Api($key, $secretKey);
        
        $payment = $api->payment->fetch($razorpay_payment_id);

         $paidAmount = $payment->amount;

         $refundAmount = $paidAmount * ((100-$percentage) / 100);

         $data = array(
             'refundAmount' => $refundAmount,
            'paidAmount' => $paidAmount,
        );
        return $data;
       

    }


    public function sendEmailTicket($request, $pnr) {
       return SendEmailTicketJob::dispatch($request, $pnr);
      }

      public function sendSmsTicket($data, $pnr) {

       

        $seatList = implode(",",$data['seat_no']);
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
        if($SmsGW == 'textLocal'){
            //Environment Variables
            //$apiKey = config('services.sms.textlocal.key');
            $apiKey = $this->credentials->first()->sms_textlocal_key;
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
            $message = str_replace("<fare>",$data['payable_amount'],$message);
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


    

}