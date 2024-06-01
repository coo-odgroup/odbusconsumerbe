<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use DB;
use PDF;
use App\Models\Bus;
use App\Models\Booking;
use App\Models\BusType;
use App\Models\BusClass;



class SendEmailTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $to;
    protected $name;
    protected $email_pnr;
    protected $bookingdate;
    protected $journeydate;
    protected $boarding_point;
    protected $dropping_point;
    protected $departureTime;
    protected $arrivalTime;
    protected $seat_no;
    protected $busname;
    protected $source;
    protected $destination;
    protected $busNumber;      
    protected $bustype;
    protected $busTypeName;
    protected $sittingType;
    protected $totalfare;
    protected $discount;
    protected $payable_amount;
    protected $odbus_gst;
    protected $odbus_charges;
    protected $owner_fare;
    protected $customer_comission;
    protected $conductor_number;
    protected $agent_number;
    protected $customer_number;    
    protected $passengerDetails;
    protected $total_seats;
    protected $seat_names;
    protected $subject;
    protected $qrCodeText;
    protected $qrcode_image_path;
    protected $cancelation_policy;
    protected $transactionFee;
    protected $customer_gst_status;
    protected $customer_gst_number;
    protected $customer_gst_business_name;
    protected $customer_gst_business_email;
    protected $customer_gst_business_address;
    protected $customer_gst_percent;
    protected $customer_gst_amount;
    protected $coupon_discount;
    protected $p_names;
    protected $add_festival_fare;
    protected $add_special_fare;
    protected $routedetails;
    protected $ticketpdf; 
    protected $email_pdf; 
    
    protected $gstpdf;    
    protected $gst_name;
    protected $bus_sitting;
    protected $bus_type;
    

    public function __construct($totalfare,$discount,$payable_amount,$odbus_charges,$odbus_gst,$owner_fare,$request, $pnr,$cancelation_policy,$transactionFee,$customer_gst_status,$customer_gst_number,$customer_gst_business_name,$customer_gst_business_email,$customer_gst_business_address,$customer_gst_percent,$customer_gst_amount,$coupon_discount)

    {
        ///////// get additional festival fare & special fare (oct , 7,2023 changes made by Lima)

        $bk_dtl=Booking::with(["bus" => function($bs){
            $bs->with('BusType.busClass');
            $bs->with('BusSitting');  
          } ] )->where('pnr', $pnr)->first();

          $this->bus_sitting = $bk_dtl->bus->BusSitting->name;
          $this->bus_type = $bk_dtl->bus->BusType->name;

        $this->add_festival_fare = $bk_dtl->additional_festival_fare;
        $this->add_special_fare = $bk_dtl->additional_special_fare;

        ////////////////////////////////////////////////////////////////////////////////////////////
        $this->name = $request['name'];
        $this->to = $request['email'];
        $this->bookingdate = date('d-m-Y',strtotime($request['bookingdate']));
        $this->journeydate = date('d-m-Y',strtotime($request['journeydate']));
        $this->boarding_point = $request['boarding_point'];
        $this->dropping_point = $request['dropping_point'];
        $this->departureTime = $request['departureTime'];
        $this->arrivalTime = $request['arrivalTime'];
        $this->seat_no = $request['seat_no'];
        $this->busname = $request['busname'];
        $this->source = $request['source'];
        $this->destination = $request['destination'];
        if(!isset($request['routedetails'])){
            $this->routedetails = $request['source'].' To '.$request['destination'];
        }else{
            $this->routedetails = $request['routedetails'];
        }
        
        
        $this->busNumber = $request['busNumber'];
        $this->bustype = $request['bustype'];
        $this->busTypeName = $request['busTypeName'];
        $this->sittingType = $request['sittingType'];

        $this->totalfare = $totalfare;
        $this->discount = $discount;
        $this->payable_amount = $payable_amount;
        $this->odbus_gst = $odbus_gst;
        $this->odbus_charges = $odbus_charges;
        $this->owner_fare = $owner_fare;
        $this->transactionFee = $transactionFee;

        $this->customer_gst_status = $customer_gst_status;
        $this->customer_gst_number = $customer_gst_number;
        $this->customer_gst_business_name = $customer_gst_business_name;
        $this->customer_gst_business_email = $customer_gst_business_email;
        $this->customer_gst_business_address = $customer_gst_business_address;
        $this->customer_gst_percent = $customer_gst_percent;
        $this->customer_gst_amount = $customer_gst_amount;
        $this->coupon_discount = $coupon_discount;
        
        $this->cancelation_policy = $cancelation_policy;

        $this->conductor_number = $request['conductor_number'];
        $this->agent_number = (isset($request['agent_number'])) ? $request['agent_number'] : '';        
        $this->customer_number = $request['phone'];
        $this->passengerDetails = $request['passengerDetails'];
        $this->total_seats = count($request['passengerDetails']); 
///////////////////////////
        $collection = collect($request['seat_no']);
        $this->seat_names = $collection->implode(',');
        ///$this->seat_names = implode(',',$request['seat_no']);
///////////////////////////
        $this->customer_comission =  (isset($request['customer_comission'])) ? $request['customer_comission'] : 0;
    
        $this->email_pnr= $pnr;

       $CONSUMER_FRONT_URL=Config::get('constants.CONSUMER_FRONT_URL');

       $this->qrCodeText= $CONSUMER_FRONT_URL."pnr/".$pnr;

       //Log::info($this->qrCodeText);

        \QrCode::size(500)
        ->format('png')
        ->generate($this->qrCodeText, public_path('qrcode/'.$pnr.'.png')); 

        $this->subject ='';
        $this->qrcode_image_path = url('public/qrcode/'.$pnr.'.png');


        $p_name=[];
        foreach($request['passengerDetails'] as $p){
            $pp = $p['passenger_name']." (".$p['passenger_gender'].") ";
            array_push($p_name,$pp);
        }

        $pp_names='';

        if($p_name){
            $pp_names = implode(',',$p_name);
        }

        $this->p_names=$pp_names;

        $this->ticketpdf=public_path('ticketpdf/'.$pnr.'.pdf');
        $this->email_pdf= 'https://consumer.odbus.co.in/public/ticketpdf/'.$pnr.'.pdf'; 

        $this->gst_name='';

        if($customer_gst_status==1){

        $gst_name='OB-000082.pdf';
        $updated_at=date('Y-m-d H:i');

        $invoice=DB::table('booking')->where('status',1)->where('gst_invoice_no','!=',null)->orderby('updated_at','desc')->first();// check if any invoice no added

        $pnr_invoice=DB::table('booking')->where('pnr',$pnr)->first();// check if any invoice no added

        if($pnr_invoice->gst_invoice_no!=''){
            $gst_name=$pnr_invoice->gst_invoice_no;
        }

        else if($invoice && $pnr_invoice->gst_invoice_no==''){
            $nm=str_replace("OB-","",$invoice->gst_invoice_no);
            $nm=str_replace(".pdf","",$nm);
            $nm=ltrim("$nm",0);
            $gst_name=(int)$nm+1;

            if($gst_name<100){
                $gst_name='OB-0000'.$gst_name.'.pdf';
            }
            else if($gst_name<1000){
                $gst_name='OB-000'.$gst_name.'.pdf';
            }
            else if($gst_name<10000){
                $gst_name='OB-00'.$gst_name.'.pdf';
            }
            else if($gst_name<100000){
                $gst_name='OB-0'.$gst_name.'.pdf';
            }
            else if($gst_name<1000000){
                $gst_name='OB-'.$gst_name.'.pdf';
            }

        }
        DB::table('booking')->where('pnr', $pnr)->update(['gst_invoice_no' => $gst_name,'updated_at' => $updated_at]); 

        $this->gst_name=$gst_name;

        $this->gstpdf='https://consumer.odbus.co.in/public/gst/'.$gst_name;
    }
 
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        
        $rr=explode(' To ',$this->routedetails);
      
        $data = [
            'name' => $this->name,
            'pnr' => $this->email_pnr,
            'bookingdate'=> $this->bookingdate,
            'journeydate' => $this->journeydate ,
            'boarding_point'=> $this->boarding_point,
            'dropping_point' => $this->dropping_point,
            'departureTime'=> $this->departureTime,
            'arrivalTime'=> $this->arrivalTime,
            'seat_no' => $this->seat_no,
            'busname'=> $this->busname,
            'source'=> $this->source,
            'destination'=> $this->destination,
            'routedetails'=>$this->routedetails,
            'start'=>$rr[0],
            'end'=>$rr[1],
            'busNumber'=> $this->busNumber,
            'bustype' => $this->bustype,
            'busTypeName' => $this->busTypeName,
            'sittingType' => $this->sittingType, 
            'conductor_number'=> $this->conductor_number,
            'customer_number'=> $this->customer_number,
            'agent_number'=> $this->agent_number,
            'passengerDetails' => $this->passengerDetails ,
            'totalfare'=> $this->totalfare,
            'discount' =>  $this->discount,
            'payable_amount' => $this->payable_amount ,
            'odbus_gst'=> $this->odbus_gst,
            'odbus_charges'=> $this->odbus_charges,
            'owner_fare'=> $this->owner_fare,
            'transactionFee'=> $this->transactionFee,             
            'customer_gst_status'=> $this->customer_gst_status, 
            'customer_gst_number'=> $this->customer_gst_number, 
            'customer_gst_business_name'=> $this->customer_gst_business_name, 
            'customer_gst_business_email'=> $this->customer_gst_business_email, 
            'customer_gst_business_address'=> $this->customer_gst_business_address, 
            'customer_gst_percent'=> $this->customer_gst_percent, 
            'customer_gst_amount'=> $this->customer_gst_amount, 
            'coupon_discount'=> $this->coupon_discount,
            'total_seats'=>  $this->total_seats ,
            'seat_names'=>  $this->seat_names ,
            'customer_comission'=> $this->customer_comission,
            'qrcode_image_path' => $this->qrcode_image_path ,
            'cancelation_policy' => $this->cancelation_policy,
            'p_names' => $this->p_names, 
            'add_festival_fare' => $this->add_festival_fare, 
            'add_special_fare' => $this->add_special_fare, 
            'bus_type' => $this->bus_type,
            'bus_sitting' => $this->bus_sitting,
            'gst_name' => str_replace('.pdf','',$this->gst_name),
            
        ];

       
        PDF::loadView('htmlPdf',$data)->save($this->ticketpdf);
 
        $this->subject = config('services.email.subjectTicket');
        $this->subject = str_replace("<PNR>",$this->email_pnr,$this->subject);
        //dd($this->subject);
        if($this->customer_gst_status==0){   
            Mail::send('emailTicket', $data, function ($messageNew) {
                $messageNew->attach($this->email_pdf)->to($this->to)
                ->subject($this->subject);
            });
        }

        else if($this->customer_gst_status==1){
            PDF::loadView('Gst',$data)->save(public_path().'/gst/'.$this->gst_name);

            Mail::send('emailTicket', $data, function ($messageNew) {
                $messageNew->attach($this->email_pdf)->attach($this->gstpdf)->to($this->to)
                ->subject($this->subject);
            });

            /// send copy to mailto:reports@odbus.in

            Mail::send('emailTicket', $data, function ($messageNew) {
                $messageNew->attach($this->email_pdf)->attach($this->gstpdf)->to('reports@odbus.in')
                ->subject($this->subject);
            });
        }

       
       
        
      
        // // check for failures
        // if (Mail::failures()) {
        //     return new Error(Mail::failures()); 
        //     //return "Email failed";
        // }

    }
}
