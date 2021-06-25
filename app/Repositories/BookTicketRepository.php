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

class BookTicketRepository
{
    protected $bus;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $bookingDetail;

    public function __construct(Bus $bus,Location $location,Users $users,BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail)
    {
        $this->bus = $bus;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
    }   
    
    public function bookTicket($request)
    { 
        $customerInfo = $request['customerInfo'];
        //find customer_id using email or phone no
        $userId = $this->users->where('email',$customerInfo['email'])->orWhere('phone',$customerInfo['phone'])->find('id');

        // if( $existingCustomer == true){
        //     $userId = $this->users->where('email',$customerInfo['email'])->orWhere('phone',$customerInfo['phone'])->get('id');
        //     return $userId;
        // //     $this->users->whereIn('id', $userId)->update($request['customerInfo']);
        // }
        // //create New Customer information
        // else{
        //     $newuserid = $this->users->create($request['customerInfo']);
        //     //return  $newuserid;
        // }
   
        if($userId){
        //Update Ticket Status in bus_seats Change bookStatus to 1(Booked)
        $seatIds = $request['seat_id'];
        $bookStatus = $request['bookStatus'];
        $this->busSeats->whereIn('id', $seatIds)->update(array('bookStatus' => $bookStatus));
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
        
        $booking->pnr =  $PNR;
        //$booking->pnr = 'OD'."".substr(str_shuffle("0123456789"), 0, 8);
        $booking->bus_id = $bookingInfo['bus_id'];
        $booking->source_id = $bookingInfo['source_id'];
        $booking->destination_id =  $bookingInfo['destination_id'];
        $booking->j_day = $bookingInfo['j_day'];
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
        else{
            return 'User not Registered';
        } 
    }
}