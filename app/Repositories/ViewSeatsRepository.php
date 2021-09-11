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

    public function __construct(Bus $bus,TicketPrice $ticketPrice,BoardingDroping $boardingDroping,Location $location,BusSeats $busSeats, Seats $seats, BusStoppageTiming $busStoppageTiming,BusLocationSequence $busLocationSequence,BookingSequence $bookingSequence,BookingDetail $bookingDetail,Booking $booking)
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
    }   
    
    public function getAllViewSeats($request)
    { 
        $booked = Config::get('constants.BOOKED_STATUS');

        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busId = $request['busId'];
        $journeyDate = $request['entry_date'];
        $journeyDate = date("Y-m-d", strtotime($journeyDate));

        $requestedSeq = $this->busLocationSequence->whereIn('location_id',[$sourceId,$destinationId])
                                        ->pluck('sequence');
        $reqRange = Arr::sort($requestedSeq);

        $busSeatsIds = $this->busSeats->where('bus_id',$busId)->pluck('id');                     
        //1,2,3,4,5,6....
///////////////>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        //$bookingDetail = $this->booking->where('bus_id',$busId)->where('status',$booked)->with('bookingDetail')->get();         
        $bookingIds = $this->booking->where('bus_id',$busId)
                                    ->where('journey_dt',$journeyDate)
                                    ->where('status',$booked)
                                    ->pluck('id');
                                  
       if (sizeof($bookingIds)){
        $blockedSeats=array();
        foreach($bookingIds as $bookingId){
            
            $bookedSeatIds = $this->bookingDetail->where('booking_id',$bookingId)
                                                 ->pluck('bus_seats_id');

            foreach($bookedSeatIds as $bookedSeatId){
                $seatsIds[] = $this->busSeats->where('id',$bookedSeatId)->first()->seats_id;
                $gender[] = $this->bookingDetail->where('booking_id',$bookingId)
                                            ->where('bus_seats_id',$bookedSeatId)
                                            ->first()->passenger_gender;     
            }   
           
             $srcId=  $this->booking->where('id',$bookingId)->first()->source_id;
             $destId= $this->booking->where('id',$bookingId)->first()->destination_id;
             $bookedSequence = $this->busLocationSequence->whereIn('location_id',[$srcId,$destId])
                             ->orderBy('id')
                             ->pluck('sequence');
             $bookedRange = Arr::sort($bookedSequence);

             //seat available on requested seq so flag "true"
            if((last($reqRange)<=head($bookedRange)) || (last($bookedRange)<=head($reqRange))){
                $flag = 'true';
            }
            else{   //seat not available on requested seq so "false"    
                $blockedSeats = array_merge($blockedSeats,$seatsIds);
                $flag = 'false';
            } 
        }
        //return $gender;
        $viewSeat = $this->getSeatInfo($busId,$blockedSeats,$flag);
       }else{//no booking on that specific date
            $blockedSeats=array();
            $flag = 'true';
            $viewSeat = $this->getSeatInfo($busId,$blockedSeats,$flag);
       }
  
            // Add Gender into Booked seat List
            if (sizeof($bookingIds)){
                $i=0;   
                foreach($viewSeat['lower_berth'] as &$lb){
                    if(in_array($lb['id'], $blockedSeats)){
                        $key = array_search($lb['id'], $seatsIds);
                        $viewSeat['lower_berth'][$i]['Gender'] = $gender[$key];
                    } 
                    $i++;
                }  
                $i=0; 
                foreach($viewSeat['upper_berth'] as &$ub){
                    if(in_array($ub['id'], $blockedSeats)){
                        $key = array_search($ub['id'], $seatsIds);
                        $viewSeat['upper_berth'][$i]['Gender'] =  $gender[$key];
                    } 
                    $i++;
                }   
            }
            return $viewSeat;
    }

    public function getSeatInfo($busId,$seatsIds,$flag){
        $lowerBerth = Config::get('constants.LOWER_BERTH');
        $upperBerth = Config::get('constants.UPPER_BERTH');

        if($flag == 'false')//Dont display the blocked seats
        {
            $result['bus']=$busRecord=$this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
            // Lower Berth seat Calculation
            $result['lower_berth']=$this->seats
                ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                ->where('berthType', $lowerBerth)
                ->with(["busSeats" => function ($query) use ($busId,$seatsIds){
                $query->where('bus_id',$busId) 
                    ->whereNotIn('seats_id',$seatsIds);
            }])
            ->get();

            if(($result['lower_berth'])->isEmpty()){
                unset($result['lower_berth']);   
            }else{
                $rowsColumns = $this->seats
                ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                ->where('berthType', $lowerBerth);
                $result['lowerBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
                $result['lowerBerth_totalColumns']=$rowsColumns->max('colNumber')+1; 
            } 
            // Upper Berth seat Calculation
            $result['upper_berth']=$this->seats
                    ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                    ->where('berthType', $upperBerth)
                    ->with(["busSeats" => function ($query) use ($busId,$seatsIds){
                        $query->where('bus_id',$busId)
                        ->whereNotIn('seats_id',$seatsIds);
                    }])
                    ->get();
            if(($result['upper_berth'])->isEmpty()){
                unset($result['upper_berth']); 
            }else{
                $rowsColumns = $this->seats
                ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                ->where('berthType', $upperBerth);
                $result['upperBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
                $result['upperBerth_totalColumns']=$rowsColumns->max('colNumber')+1;  
            }
            return $result;
        }else{  ///seats are available
            $result['bus']=$busRecord=$this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
            // Lower Berth seat Calculation
            $result['lower_berth']=$this->seats
                                        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                                        ->where('berthType', $lowerBerth)
                                        ->with(["busSeats" => function ($query) use ($busId,$seatsIds){
                $query->where('bus_id',$busId);
            }])
            ->get();
            if(($result['lower_berth'])->isEmpty()){
                unset($result['lower_berth']);   
            }else{
                $rowsColumns = $this->seats
                                    ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                                    ->where('berthType', $lowerBerth);
                $result['lowerBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
                $result['lowerBerth_totalColumns']=$rowsColumns->max('colNumber')+1;
            } 
            // Upper Berth seat Calculation
            $result['upper_berth']=$this->seats
                                        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                                        ->where('berthType', $upperBerth)
                                        ->with(["busSeats" => function ($query) use ($busId){
                                                $query->where('bus_id',$busId);
                    }])
                    ->get();
            if(($result['upper_berth'])->isEmpty()){
                unset($result['upper_berth']); 
            }else{
                $rowsColumns = $this->seats
                                    ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
                                    ->where('berthType', $upperBerth);
                $result['upperBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
                $result['upperBerth_totalColumns']=$rowsColumns->max('colNumber')+1;  
            }
            return $result;
        }
    }

    
    public function getPriceOnSeatsSelection($request)
    { 
        $seaterIds = (isset($request['seater'])) ? $request['seater'] : [];
        $sleeperIds = (isset($request['sleeper'])) ? $request['sleeper'] : [];
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];

        $busWithTicketPrice = $this->ticketPrice
                ->where('source_id', $sourceId)
                ->where('destination_id', $destinationId)
                ->where('bus_id', $busId)           
                ->first();
        $seaterPrice = $busWithTicketPrice->base_seat_fare;
        $sleeperPrice = $busWithTicketPrice->base_sleeper_fare;
        $totalPrice = count($seaterIds)*$busWithTicketPrice->base_seat_fare+
        count($sleeperIds)*$busWithTicketPrice->base_sleeper_fare;

       $seatWithPriceRecords[] = array(
        "seaterPrice" => $seaterPrice,
        "sleeperPrice" => $sleeperPrice,
        "totalPrice" => $totalPrice,
        ); 
        return $seatWithPriceRecords;
    }

    public function getBoardingDroppingPoints($request)
    { 
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $Records =  $this->busStoppageTiming->with('boardingDroping')
        ->where('bus_id', $busId)
        ->orderBy('stoppage_time', 'ASC')
        ->get();

        $boardingDroppings = array();  
        foreach($Records as $Record){  
            $boardingPoints = $Record->boardingDroping->boarding_point;
            $boardingDroppingTimes = $Record->stoppage_time;
            $boardingDroppingTimes = date("H:i",strtotime($boardingDroppingTimes));
            $locationId = $Record->boardingDroping->location_id;
            $boardDropId = $Record->boardingDroping->id;
            if($locationId==$sourceId)
            {
                $boardingArray[] = array(
                    "id" =>  $boardDropId,
                    "boardingPoints" => $boardingPoints,
                    "boardingTimes" => $boardingDroppingTimes,
                );
            }
            elseif($locationId==$destinationId)
            {
                $droppingArray[] = array(
                    "id" =>  $boardDropId,
                    "droppingPoints" => $boardingPoints,
                    "droppingTimes" => $boardingDroppingTimes,
            );
            }
    }
    $boardingDroppings[] = array(   
        "boardingPoints" => $boardingArray,
        "droppingPoints" => $droppingArray,
    );  
    return $boardingDroppings;
    }

}