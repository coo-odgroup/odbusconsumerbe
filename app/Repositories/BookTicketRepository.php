<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\BookingCustomer;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;

class BookTicketRepository
{
    protected $bus;
    protected $location;
    protected $bookingCustomer;
    protected $booking;
    protected $busSeats;
    protected $bookingDetail;

    public function __construct(Bus $bus,Location $location,BookingCustomer $bookingCustomer,BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail)
    {
        $this->bus = $bus;
        $this->location = $location;
        $this->bookingCustomer = $bookingCustomer;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
    }   
    
    public function bookTicket($request)
    { 
      $MailId = $request['email'];
      $phone = $request['phone'];

        //find customer_id using email or phone no
       $customerId = $this->bookingCustomer->where('email', $MailId)->orWhere('phone', $phone)->find('id');
       return $customerId;
         
        ////return customer_info if record found
        //else create a custmer and return custumer_info
        //$customerInfo = $request['customerInfo'];

        $bookingInfo = $request['bookingInfo'];

        //Update Ticket Status in bus_seats Change bookStatus to 1(Booked)
        $seatIds = $request['seat_id'];
        $bookStatus = $request['bookStatus'];
        $this->busSeats->whereIn('id', $seatIds)->update(array('bookStatus' => $bookStatus));
        //Save Booking 
        $booking = new $this->booking;
        do {
           $transactionId = date('YmdHis') . gettimeofday()['usec'];
           } while ( $booking ->where( 'transaction_id', $transactionId )->exists());
        $booking->transaction_id =  $transactionId;
        $booking->pnr =  $bookingInfo['pnr'];
        $booking->booking_customer_id = $bookingInfo['booking_customer_id'];
        $booking->bus_operator_id = $bookingInfo['bus_operator_id'];
        $booking->bus_id = $bookingInfo['bus_id'];
        $booking->source_id = $bookingInfo['source_id'];
        $booking->destination_id =  $bookingInfo['destination_id'];
        $booking->j_day = $bookingInfo['j_day'];
        $booking->journey_dt = $bookingInfo['journey_dt'];
        $booking->boarding_point = $bookingInfo['boarding_point'];
        $booking->dropping_point = $bookingInfo['dropping_point'];
        $booking->boarding_time = $bookingInfo['boarding_time'];
        $booking->dropping_time =  $bookingInfo['dropping_time'];
        $booking->total_fare = $bookingInfo['total_fare'];
        $booking->ownr_fare = $bookingInfo['ownr_fare'];
        $booking->is_coupon = $bookingInfo['is_coupon'];
        $booking->coupon_code = $bookingInfo['coupon_code'];
        $booking->coupon_discount = $bookingInfo['coupon_discount'];
        $booking->discounted_fare =  $bookingInfo['discounted_fare'];
        $booking->origin = $bookingInfo['origin'];
        $booking->app_type = $bookingInfo['app_type'];
        $booking->typ_id = $bookingInfo['typ_id'];
        $booking->created_by = $bookingInfo['created_by'];
        $booking->save();

        //Update Booking Details

        $bookingDetailModels = [];
         //TOD Latter,Write Enhanced Query
        foreach ($bookingInfo['bookingDetail'] as $bDetail) {
        $bookingDetailModels[] = new BookingDetail($bDetail);
        }
        $booking->bookingDetail()->saveMany($bookingDetailModels);
        return $booking; 
        

         //Save Customer Data
        //  $customer = new $this->bookingCustomer;
        //  $customer->first_name = $customerInfo['first_name'];
        //  $customer->last_name =  $customerInfo['last_name'];
        //  $customer->age = $customerInfo['age'];
        //  $customer->email = $customerInfo['email'];
        //  $customer->phone = $customerInfo['phone'];
        //  $customer->created_by = $customerInfo['created_by'];
        //  $customer->save();

    }
}