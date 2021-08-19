<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;
use App\Models\TicketPrice;
use App\Repositories\ChannelRepository;

class BookTicketRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $bookingDetail;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail,ChannelRepository $channelRepository)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
        $this->channelRepository = $channelRepository; 
    }   
    
    public function bookTicket($request)
    { 
        $customerInfo = $request['customerInfo'];
        $existingUser = $this->users->where('phone',$customerInfo['phone'])
                                //->orWhere('email', $customerInfo['email'])
                                ->exists(); 
        if($existingUser==true){
            $userId = $this->users->where('phone',$customerInfo['phone'])
                            //->orWhere('email',$customerInfo['email'])
                            ->first('id');
           $this->users->whereIn('id', $userId)->update($customerInfo);     
        }
        else{
            $userId = $this->users->create($request['customerInfo'])->latest('id')->first('id');   
        }
        
        $bookingInfo = $request['bookingInfo'];
        //Save Booking 
        $booking = new $this->booking;
        do {
           $transactionId = date('YmdHis') . gettimeofday()['usec'];
           } while ( $booking ->where('transaction_id', $transactionId )->exists());
        $booking->transaction_id =  $transactionId;
        do {
            $PNR = 'OD'."".substr(str_shuffle("0123456789"), 0, 8);
            } while ( $booking ->where('pnr', $PNR )->exists()); 
        $booking->pnr = $PNR;
        $booking->bus_id = $bookingInfo['bus_id'];
        $busId = $bookingInfo['bus_id'];
        $booking->source_id = $bookingInfo['source_id'];
        $booking->destination_id =  $bookingInfo['destination_id'];
        $j_day = $this->ticketPrice->where('bus_id',$busId)->pluck('j_day');
        $booking->j_day = $j_day[0];
        //$booking->j_day = $bookingInfo['j_day'];
        $booking->journey_dt = $bookingInfo['journey_dt'];
        $booking->boarding_point = $bookingInfo['boarding_point'];
        $booking->dropping_point = $bookingInfo['dropping_point'];
        $booking->boarding_time = $bookingInfo['boarding_time'];
        $booking->dropping_time =  $bookingInfo['dropping_time'];
        $booking->origin = $bookingInfo['origin'];
        $booking->app_type = $bookingInfo['app_type'];
        $booking->typ_id = $bookingInfo['typ_id'];
        $booking->created_by = $bookingInfo['created_by'];

        $userId->booking()->save($booking);
           
        //$booking->save();

        //Update Booking Details
        $bookingDetailModels = [];
         //TOD Latter,Write Enhanced Query
        foreach ($bookingInfo['bookingDetail'] as $bDetail) {
        $bookingDetailModels[] = new BookingDetail($bDetail);
        }
        $booking->bookingDetail()->saveMany($bookingDetailModels);
        return $booking;
       
    }
}