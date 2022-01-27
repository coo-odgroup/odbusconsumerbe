<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
    protected $customer_number;    
    protected $passengerDetails;
    protected $total_seats;
    protected $seat_names;
    protected $subject;
    
    



    //protected $request = [];
    //public function __construct($to, $name, $email_pnr)
    public function __construct($request, $email_pnr)

    {
      
        //$this->$request[] = $request;
        $this->name = $request['name'];
        $this->to = $request['email'];
        $this->bookingdate = $request['bookingdate'];
        $this->journeydate = $request['journeydate'];
        $this->boarding_point = $request['boarding_point'];
        $this->dropping_point = $request['dropping_point'];
        $this->departureTime = $request['departureTime'];
        $this->arrivalTime = $request['arrivalTime'];
        $this->seat_no = $request['seat_no'];
        $this->busname = $request['busname'];
        $this->source = $request['source'];
        $this->destination = $request['destination'];
        $this->busNumber = $request['busNumber'];
        $this->bustype = $request['bustype'];
        $this->busTypeName = $request['busTypeName'];
        $this->sittingType = $request['sittingType'];
        $this->totalfare = $request['totalfare'];
        $this->discount = $request['discount'];
        $this->payable_amount = $request['payable_amount'];
        $this->odbus_gst = $request['odbus_gst'];
        $this->odbus_charges = $request['odbus_charges'];
        $this->owner_fare = $request['owner_fare'];
        $this->conductor_number = $request['conductor_number'];
        $this->customer_number = $request['phone'];
        $this->passengerDetails = $request['passengerDetails'];
        $this->total_seats = count($request['passengerDetails']);       
        $this->seat_names = implode(',',$request['seat_no']);
        $this->customer_comission =  (isset($request['customer_comission'])) ? $request['customer_comission'] : 0;
    
        $this->email_pnr= $email_pnr;

        $this->subject ='';

    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {


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
            'busNumber'=> $this->busNumber,
            'bustype' => $this->bustype,
            'busTypeName' => $this->busTypeName,
            'sittingType' => $this->sittingType, 
            'conductor_number'=> $this->conductor_number,
            'customer_number'=> $this->customer_number,
            'passengerDetails' => $this->passengerDetails ,
            'totalfare'=> $this->totalfare,
            'discount' =>  $this->discount,
            'payable_amount' => $this->payable_amount ,
            'odbus_gst'=> $this->odbus_gst,
            'odbus_charges'=> $this->odbus_charges,
            'owner_fare'=> $this->owner_fare,
            'total_seats'=>  $this->total_seats ,
            'seat_names'=>  $this->seat_names ,
            'customer_comission'=> $this->customer_comission
            
        ];
             
        $this->subject = config('services.email.subjectTicket');
        $this->subject = str_replace("<PNR>",$this->email_pnr,$this->subject);
        //dd($this->subject);
        Mail::send('emailTicket', $data, function ($messageNew) {
            $messageNew->to($this->to)
            //->subject(config('services.email.subjectTicket'));
            ->subject($this->subject);
        });
        
        // check for failures
        if (Mail::failures()) {
            return new Error(Mail::failures()); 
            //return "Email failed";
        }

    }
}
