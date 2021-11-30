<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\TicketPrice;
use App\Models\BoardingDroping;
use App\Models\Location;
use App\Models\BusSeats;
use App\Models\Seats;
use App\Models\BusStoppageTiming;
use App\Models\BusLocationSequence;
use App\Models\BookingSequence;
use App\Models\BookingDetail;
use App\Models\Booking;
use App\Models\TicketFareSlab;
use App\Models\OdbusCharges;
use App\Models\SeatOpenSeats;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use DB;

class ViewSeatsRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $boardingDroping;
    protected $location;
    protected $busSeats;
    protected $busStoppageTiming;
    protected $busLocationSequence;
    protected $bookingSequence;
    protected $bookingDetail;
    protected $booking;
    protected $ticketFareSlab;
    protected $odbusCharges;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,BoardingDroping $boardingDroping,Location $location,BusSeats $busSeats, Seats $seats, BusStoppageTiming $busStoppageTiming,BusLocationSequence $busLocationSequence,BookingSequence $bookingSequence,BookingDetail $bookingDetail,Booking $booking,TicketFareSlab $ticketFareSlab,OdbusCharges $odbusCharges)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->boardingDroping = $boardingDroping;
        $this->location = $location;
        $this->busSeats = $busSeats;
        $this->seats=$seats;
        $this->busStoppageTiming=$busStoppageTiming;
        $this->busLocationSequence=$busLocationSequence;
        $this->bookingSequence=$bookingSequence;
        $this->bookingDetail=$bookingDetail;
        $this->booking=$booking;
        $this->ticketFareSlab = $ticketFareSlab;
        $this->odbusCharges = $odbusCharges;  
    } 
    
    public function busLocationSequence($sourceId,$destinationId)
    {
        return $this->busLocationSequence->whereIn('location_id',[$sourceId,$destinationId])
        ->pluck('sequence');
    }

    public function bookingIds($busId,$journeyDate,$booked,$seatHold){
        return $this->booking->where('bus_id',$busId)
        ->where('journey_dt',$journeyDate)
        ->whereIn('status',[$booked,$seatHold])
        ->pluck('id'); 
    }

    public function bookingDetail($bookingId)
    {
        return $this->bookingDetail->where('booking_id',$bookingId)
        ->pluck('bus_seats_id');
    }

    public function busSeats($bookedSeatId){
        return $this->busSeats->where('id',$bookedSeatId)->first()->seats_id;
    }

    public function bookingGenderDetail($bookingId,$bookedSeatId){
        return  $this->bookingDetail->where('booking_id',$bookingId)
        ->where('bus_seats_id',$bookedSeatId)
        ->first()->passenger_gender; 
    }

    public function getSourceId($bookingId){
        return $this->booking->where('id',$bookingId)->first()->source_id;
    }

    public function getDestinationId($bookingId){
        return $this->booking->where('id',$bookingId)->first()->destination_id;
    }

    public function bookedSequence($srcId,$destId){
        return $this->busLocationSequence->whereIn('location_id',[$srcId,$destId])
        ->orderBy('id')
        ->pluck('sequence');
    }

    public function busRecord($busId){
        return $this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
    }

    public function getBerth($bus_seat_layout_id,$Berth,$flag,$busId,$seatsIds){
        return $this->seats
               ->where('bus_seat_layout_id',$bus_seat_layout_id)
               ->where('berthType', $Berth)
               ->with(["busSeats"=> function ($query) use ($flag,$busId,$seatsIds){
                   $query->when($flag == 'false', 
                   function($q) use ($busId,$seatsIds){  //hide booked Seats
                           $q->where('bus_id',$busId) 
                           ->whereNotIn('seats_id',$seatsIds);
                   },
                   function($q) use ($busId,$seatsIds){  //Display unbooked Seats
                           $q->where('bus_id',$busId); 
                   });
               }]) 
                ->get();
    }

    public function seatRowColumn($bus_seat_layout_id,$Berth){
        return $this->seats
        ->where('bus_seat_layout_id',$bus_seat_layout_id)
        ->where('berthType', $Berth);
    }
    
   
    public function busWithTicketPrice($sourceId,$destinationId,$busId){
        return  $this->ticketPrice
        ->where('source_id', $sourceId)
        ->where('destination_id', $destinationId)
        ->where('bus_id', $busId)           
        ->first();
    }

    public function ticketFareSlab($busOperatorId){
        if(isset($busOperatorId)){
        return $this->ticketFareSlab->where('bus_operator_id', $busOperatorId)->get();
        }else{
        return $this->ticketFareSlab->get();
        }
    }

    public function odbusCharges(){
        return $this->odbusCharges->get();
    }
 
    public function busStoppageTiming($busId){
      return  $this->busStoppageTiming->with('boardingDroping')
        ->where('bus_id', $busId)
        ->orderBy('stoppage_time', 'ASC')
        ->get();
    }

}