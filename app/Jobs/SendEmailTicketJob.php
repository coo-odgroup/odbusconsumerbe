<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
    protected $seat_id;
    protected $busname;
    protected $busNumber;      
    protected $bustype;
    protected $busTypeName;
    protected $sittingType;
    protected $totalfare;
    protected $conductor_number;
    protected $passengerDetails;



    //protected $request = [];
    //public function __construct($to, $name, $email_pnr)
    public function __construct(array &$request, $email_pnr)

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
        $this->seat_id = $request['seat_id'];
        $this->busname = $request['busname'];
        $this->busNumber = $request['busNumber'];
        $this->bustype = $request['bustype'];
        $this->busTypeName = $request['busTypeName'];
        $this->sittingType = $request['sittingType'];
        $this->totalfare = $request['totalfare'];
        $this->conductor_number = $request['conductor_number'];
        $this->passengerDetails = $request['passengerDetails'];
    
        $this->email_pnr= $email_pnr;

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
            'seat_id' => $this->seat_id,
            'busname'=> $this->busname,
            'busNumber'=> $this->busNumber,
            'bustype' => $this->bustype,
            'busTypeName' => $this->busTypeName,
            'sittingType' => $this->sittingType, 
            'conductor_number'=> $this->conductor_number,
            'passengerDetails' => $this->passengerDetails ,
            'totalfare'=> $this->totalfare,
            
        ];
        //dd($data);
        Mail::send('emailTicket', $data, function ($messageNew) {
            $messageNew->to($this->to)
            ->subject(config('services.email.subjectTicket'));
        });

    }
}
