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
    
    public function getAllViewSeats($request)
    { 
        $booked = Config::get('constants.BOOKED_STATUS');
        $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
        
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busId = $request['busId'];
        $journeyDate = $request['entry_date'];
        $journeyDate = date("Y-m-d", strtotime($journeyDate));

        $requestedSeq = $this->busLocationSequence->whereIn('location_id',[$sourceId,$destinationId])
                                                  ->pluck('sequence');

        $reqRange = Arr::sort($requestedSeq);
        //$busSeatsIds = $this->busSeats->where('bus_id',$busId)->pluck('id');                     
        //1,2,3,4,5,6.... 
        $bookingIds = $this->booking->where('bus_id',$busId)
                                    ->where('journey_dt',$journeyDate)
                                    ->whereIn('status',[$booked,$seatHold])
                                    ->pluck('id');                          
       if (sizeof($bookingIds)){
        $blockedSeats=array();
        foreach($bookingIds as $bookingId){
            $bookedSeatIds = $this->bookingDetail->where('booking_id',$bookingId)
                                                 ->pluck('bus_seats_id');
        //return  $bookedSeatIds;
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
        $viewSeat = $this->getSeatInfo($busId,$blockedSeats,$flag,$journeyDate);
       }else{//no booking on that specific date
            $blockedSeats=array();
            $flag = 'true';
            $viewSeat = $this->getSeatInfo($busId,$blockedSeats,$flag,$journeyDate);
       }
  
            // Add Gender into Booked seat List
            if (sizeof($bookingIds)){
                $i=0;
              
              if(isset($viewSeat['lower_berth'])){
                foreach($viewSeat['lower_berth'] as &$lb){
                    if(in_array($lb['id'], $blockedSeats)){
                        $key = array_search($lb['id'], $seatsIds);
                        $viewSeat['lower_berth'][$i]['Gender'] = $gender[$key];
                    } 
                    $i++;
                } 
              }
                $i=0; 
                if(isset($viewSeat['upper_berth'])){  
                  foreach($viewSeat['upper_berth'] as &$ub){
                    if(in_array($ub['id'], $blockedSeats)){
                        $key = array_search($ub['id'], $seatsIds);
                        $viewSeat['upper_berth'][$i]['Gender'] =  $gender[$key];
                    } 
                    $i++;
                }   
                  
                }
                
            }
            return $viewSeat;
    }

    public function getSeatInfo($busId,$seatsIds,$flag,$journeyDate){
        $lowerBerth = Config::get('constants.LOWER_BERTH');
        $upperBerth = Config::get('constants.UPPER_BERTH');
        $result['bus']=$busRecord=$this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
        // Lower Berth seat Calculation
        $result['lower_berth']=$this->seats
            ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
            ->where('berthType', $lowerBerth)
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
            // ->with('seatOpenSeats', function ($query) use ($flag,$busId,$seatsIds,$journeyDate){
            //     $query->when($flag == 'false', 
            //     function($q) use ($seatsIds,$busId,$journeyDate){  //hide booked Seats
            //         $q->whereNotIn('seats_id',$seatsIds);
            //         $q->with('seatOpen', function ($b) use ($busId,$journeyDate) {
            //             $b->where('bus_id',$busId)
            //             ->where('date_applied',$journeyDate);
            //         });           
            //     },
            //     function($q) use ($seatsIds,$busId,$journeyDate){  //Display unbooked Seats
            //         $q->with('seatOpen', function ($b) use ($busId,$journeyDate) {
            //             $b->where('bus_id',$busId)
            //               ->where('date_applied',$journeyDate);
            //         });           
            //     });
            // })
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
                ->with(["busSeats" => function ($query) use ($flag,$busId,$seatsIds){
                    $query->when($flag == 'false',
                    function($q) use ($busId,$seatsIds){  //Don't Display booked Seats
                            $q->where('bus_id',$busId) 
                            ->whereNotIn('seats_id',$seatsIds);
                    },
                    function($q) use ($busId,$seatsIds){  //Display unbooked Seats
                            $q->where('bus_id',$busId);
                    });
                }])
                // ->with('seatOpenSeats', function ($query) use ($flag,$busId,$seatsIds,$journeyDate){
                //     $query->when($flag == 'false', 
                //     function($q) use ($seatsIds,$busId,$journeyDate){  //hide booked Seats
                //         $q->whereNotIn('seats_id',$seatsIds);
                //         $q->with('seatOpen', function ($b) use ($busId,$journeyDate) {
                //             $b->where('bus_id',$busId)
                //             ->where('date_applied',$journeyDate);
                //         });           
                //     },
                //     function($q) use ($seatsIds,$busId,$journeyDate){  //Display unbooked Seats
                //         $q->with('seatOpen', function ($b) use ($busId,$journeyDate) {
                //             $b->where('bus_id',$busId)
                //               ->where('date_applied',$journeyDate);
                //         });           
                //     });
                // })
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
    
    public function getPriceOnSeatsSelection($request)
    { 
        $seaterIds = (isset($request['seater'])) ? $request['seater'] : [];
        $sleeperIds = (isset($request['sleeper'])) ? $request['sleeper'] : [];
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busOperatorId = $request['busOperatorId'];

        $busWithTicketPrice = $this->ticketPrice
                ->where('source_id', $sourceId)
                ->where('destination_id', $destinationId)
                ->where('bus_id', $busId)           
                ->first();
        $seaterPrice = $busWithTicketPrice->base_seat_fare;
        $sleeperPrice = $busWithTicketPrice->base_sleeper_fare;
        
        $ownerFare = count($seaterIds)*$busWithTicketPrice->base_seat_fare+
                     count($sleeperIds)*$busWithTicketPrice->base_sleeper_fare;
                    
        $ticketFareSlabs = $this->ticketFareSlab->where('bus_operator_id', $busOperatorId)->get();
        
        foreach($ticketFareSlabs as $ticketFareSlab){

            $startingFare = $ticketFareSlab->starting_fare;
            $uptoFare = $ticketFareSlab->upto_fare;
            if($startingFare <= $ownerFare && $uptoFare >= $ownerFare){
                $percentage = $ticketFareSlab->odbus_commision;
                $odbusServiceCharges = round($ownerFare * ($percentage/100));
                $odbusCharges = $this->odbusCharges->get();
                $smsEmailCharges = $odbusCharges[0]->email_sms_charges;
                $gwPercentage = ($odbusCharges[0]->payment_gateway_charges)/100;
                $gwCharges = (($ownerFare + $odbusServiceCharges + $smsEmailCharges) * $gwPercentage);
                $transactionFee = round($smsEmailCharges + $gwCharges);
                $totalFare = round($ownerFare + $odbusServiceCharges + $transactionFee);
            }  
        } 
        $seatWithPriceRecords[] = array(
            "seaterPrice" => $seaterPrice,
            "sleeperPrice" => $sleeperPrice,
            "ownerFare" => $ownerFare,
            "odbusServiceCharges" => $odbusServiceCharges,
            "transactionFee" => $transactionFee,
            "totalFare" => $totalFare,
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