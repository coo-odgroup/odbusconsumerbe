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
use App\Models\Seats;
use App\Models\TicketPrice;

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

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,
    BusSeats $busSeats,Booking $booking,BookingDetail $bookingDetail, Seats $seats)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->seats = $seats;
        $this->booking = $booking;
        $this->bookingDetail = $bookingDetail;
    }   
    
    public function getJourneyDetails($request)
    { 

        $pnr = $request['pnr'];
        $mobile = $request['mobile'];

        $journey_detail = $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr);
            $u->with("bus");
        }])->get();

        if($journey_detail){            

            if(isset($journey_detail[0]->booking)){
                 $journey_detail[0]->booking['source']=$this->location->where('id',$journey_detail[0]->booking->source_id)->get();
                 $journey_detail[0]->booking['destination']=$this->location->where('id',$journey_detail[0]->booking->destination_id)->get();
            }

        }

        return $journey_detail;
       
    }

    public function getPassengerDetails($request)
    { 

        $pnr = $request['pnr'];
        $mobile = $request['mobile'];

        $passenger_detail = $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr);
            $u->with(["bookingDetail" => function($b){
                $b->with(["busSeats" => function($s){
                    $s->with("seats");
                  } ]);
            } ]);
        }])->get();

        return $passenger_detail;
       
    }

    public function getBookingDetails($request)
    { 

        $pnr = $request['pnr'];
        $mobile = $request['mobile'];

        $booking_detail = $this->users->where('phone',$mobile)->with(["booking" => function($u) use($pnr){
            $u->where('booking.pnr', '=', $pnr);            
            $u->with("bus");
            $u->with(["bookingDetail" => function($b){
                $b->with(["busSeats" => function($s){
                    $s->with("seats");
                  } ]);
            } ]);
        }])->get();

        if($booking_detail){            

            if(isset($booking_detail[0]->booking)){
                 $booking_detail[0]->booking['source']=$this->location->where('id',$booking_detail[0]->booking->source_id)->get();
                 $booking_detail[0]->booking['destination']=$this->location->where('id',$booking_detail[0]->booking->destination_id)->get();
            }

        }

       
        return $booking_detail;
       
    }

    

}