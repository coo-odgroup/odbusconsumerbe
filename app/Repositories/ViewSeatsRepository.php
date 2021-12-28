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
    
    public function busLocationSequence($sourceId,$destinationId,$busId)
    {
        return $this->busLocationSequence->whereIn('location_id',[$sourceId,$destinationId])
        ->where('bus_id',$busId)
        ->where('status','!=', '2')
        ->pluck('sequence');
    }

    public function bookingIds($busId,$journeyDate,$booked,$seatHold){

        $maxJday =  $this->ticketPrice
        ->where('bus_id', $busId)
        ->where('status','1')
        ->max('j_day'); 
        $nday = date('Y-m-d', strtotime('+1 day', strtotime($journeyDate)));
        $yday = date('Y-m-d', strtotime('-1 day', strtotime($journeyDate)));
        switch($maxJday){
            case(1):
                return $this->booking->where('bus_id',$busId)
                ->where('journey_dt',$journeyDate)
                ->whereIn('status',[$booked,$seatHold])
                ->pluck('id');
                break;
            case(2):
                $nday = date('Y-m-d', strtotime('+1 day', strtotime($journeyDate)));
                $yday = date('Y-m-d', strtotime('-1 day', strtotime($journeyDate)));
                return $this->booking->where('bus_id',$busId)
                ->whereIn('journey_dt',[$yday,$journeyDate,$nday ])
                ->whereIn('status',[$booked,$seatHold])
                ->pluck('id'); 
                break;
        }

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

    public function bookedSequence($srcId,$destId,$busId){
        return $this->busLocationSequence->whereIn('location_id',[$srcId,$destId])
        ->where('bus_id',$busId)
        ->where('status','!=', '2')
        ->orderBy('id')
        ->pluck('sequence');
    }

    public function busRecord($busId){
        return $this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
    }

    public function getBerth($bus_seat_layout_id,$Berth,$flag,$busId,$seatsIds,$entry_date,$sourceId,$destinationId){

        $ticketPriceId = TicketPrice::where('bus_id',$busId)
           ->where('source_id',$sourceId)
           ->where('destination_id',$destinationId)
           ->where('status',1)
           ->first()->id;
       
       $blockSeats = BusSeats::where('operation_date', $entry_date)
            ->where('type',2)
            ->where('bus_id',$busId)
            ->where('ticket_price_id',$ticketPriceId)
            ->pluck('seats_id');

       $seats= $this->seats
               ->where('bus_seat_layout_id',$bus_seat_layout_id)
               ->where('berthType', $Berth)
               ->where('status','1')
               ->with(["busSeats"=> function ($query) use ($flag,$busId,$seatsIds,$entry_date,$blockSeats){
                   $query->when($flag == 'false', 
                   function($q) use ($busId,$seatsIds,$entry_date,$blockSeats){  //hide booked Seats
                        $q->where(['operation_date', $entry_date])
                            ->orwhereNull('operation_date')
                            ->where('status',1)
                            ->where('bus_id',$busId)
                            ->whereNotIn('seats_id',$seatsIds);
                   },
                   function($q) use ($busId,$seatsIds,$entry_date,$blockSeats){  //Display unbooked Seats
                        $q->where([['operation_date', $entry_date]])                        
                            ->orwhereNull('operation_date')
                            ->where('status',1)
                            ->where('bus_id',$busId);
                   });
               }]) 
                ->get();
                //////seat block//////////
                foreach($seats as $seat){ 
                    if(collect($blockSeats)->contains($seat->id)){
                        unset($seat['busSeats']);  
                    }
                }
               return $seats;
    }

    public function seatRowColumn($bus_seat_layout_id,$Berth){
        return $this->seats
        ->where('bus_seat_layout_id',$bus_seat_layout_id)
        ->where('status','1') 
        ->where('berthType', $Berth);
    }

       
   
    public function busWithTicketPrice($sourceId,$destinationId,$busId){
        return  $this->ticketPrice
        ->where('source_id', $sourceId)
        ->where('destination_id', $destinationId)
        ->where('bus_id', $busId)
        ->where('status','1') 
        ->first();
    }


    public function newFare($seat_ids,$busId,$ticket_price_id){

        return  $this->busSeats
        ->whereIn('seats_id', $seat_ids)
        ->where('bus_id', $busId)
        ->where('ticket_price_id', $ticket_price_id)
        ->where('status','1') 
        ->select('id','seats_id','new_fare') 
        ->get();

    }



    public function ticketFareSlab($busOperatorId){
    $defOperatorId = Config::get('constants.BUS_OPERATOR_ID'); 
        
    $ticketFareRecord = $this->ticketFareSlab->where('bus_operator_id', $busOperatorId)->get();
        if(isset($ticketFareRecord[0])){
            return $this->ticketFareSlab->where('bus_operator_id', $busOperatorId)->get();
        }else{
            return $this->ticketFareSlab->where('bus_operator_id', $defOperatorId)->get();
        }  
    }

    public function odbusCharges($busOperatorId){
        $defOperatorId = Config::get('constants.BUS_OPERATOR_ID');

        $odbusChargesRec = $this->odbusCharges->where('bus_operator_id', $busOperatorId)->get();
        if(isset($odbusChargesRec[0])){
            return $this->odbusCharges->where('bus_operator_id', $busOperatorId)->get();
        }else{
            return $this->odbusCharges->where('bus_operator_id', $defOperatorId)->get();
        }  

    }
 
    public function busStoppageTiming($busId){
      return  $this->busStoppageTiming
        ->with(['boardingDroping' => function ($a){
            $a->where('status',1);
            }])  
        ->where('bus_id', $busId)
        ->where('status', '1')
        ->orderBy('stoppage_time', 'ASC')
        ->groupBy('boarding_droping_id')
        ->get();
    }

}