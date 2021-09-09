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
use Carbon\Carbon;
use DateTime;

class CancelTicketRepository
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
    
    public function cancelTicket($request)
    { 
        $pnr = $request['pnr'];
        $phone = $request['phone'];

        $bookingDetails = $this->booking->with('bookingDetail')->where("pnr", $pnr)->get();
        return $bookingDetails;
        $jDate =$bookingDetails[0]->journey_dt;
        $boardTime =$bookingDetails[0]->boarding_time; 
        $bookingId =$bookingDetails[0]->id; 
        $combinedDT = date('Y-m-d H:i:s', strtotime("$jDate $boardTime"));
        $current_date_time = Carbon::now()->toDateTimeString(); 
        $datetime1 = new DateTime($combinedDT);
        $datetime2 = new DateTime($current_date_time);
        $interval = $datetime1->diff($datetime2);
        $interval = ($interval->format("%a") * 24) + $interval->format(" %h"). "h". $interval->format(" %im");
        if($interval < '12h 00m') {
                return 'Not allowed';
        }{
            $userId = $bookingDetails[0]->users_id;
            $existPhone = $this->users->where('id',$userId)->first()->phone;
            if($existPhone == $phone){
                $this->booking->where('id', $bookingId)->update(array('status' => '0')); 


                // $this->booking->deleting(function($booking) { 
                //     $booking->bookingDetail()->onDelete('cascade');   
                // });
                $this->booking->bookingDetail()->delete();
                return "booked user";
            }



            return ' allowed';
        }

        //->whereDate('date', '<=', '2014-07-10')
        

        // $userId = $this->booking->where("pnr", $pnr)->first()->users_id;
        // return $userId;
        
    }
}