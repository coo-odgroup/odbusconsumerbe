<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\ViewSeatsRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Illuminate\Support\Arr;


class ViewSeatsService
{
    protected $viewSeatsRepository;    
    public function __construct(ViewSeatsRepository $viewSeatsRepository)
    {
        $this->viewSeatsRepository = $viewSeatsRepository;
    }
    public function getAllViewSeats(Request $request)
    {

        $booked = Config::get('constants.BOOKED_STATUS');
        $seatHold = Config::get('constants.SEAT_HOLD_STATUS');
        
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busId = $request['busId'];
        $journeyDate = $request['entry_date'];
        $journeyDate = date("Y-m-d", strtotime($journeyDate));

        $requestedSeq = $this->viewSeatsRepository->busLocationSequence($sourceId,$destinationId);

        $reqRange = Arr::sort($requestedSeq);

        $bookingIds = $this->viewSeatsRepository->bookingIds($busId,$journeyDate,$booked,$seatHold);

        if (sizeof($bookingIds)){
            $blockedSeats=array();
            foreach($bookingIds as $bookingId){
                $bookedSeatIds = $this->viewSeatsRepository->bookingDetail($bookingId);
           
                foreach($bookedSeatIds as $bookedSeatId){
                    $seatsIds[] = $this->viewSeatsRepository->busSeats($bookedSeatId);
                    $gender[] = $this->viewSeatsRepository->bookingGenderDetail($bookingId,$bookedSeatId);     
                }   
               
                 $srcId=  $this->viewSeatsRepository->getSourceId($bookingId);
                 $destId=  $this->viewSeatsRepository->getDestinationId($bookingId);
                 
                 $bookedSequence = $this->viewSeatsRepository->bookedSequence($srcId,$destId);
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
            //$viewSeat = $this->viewSeatsRepository->getSeatInfo($busId,$blockedSeats,$flag,$journeyDate);
           }else{//no booking on that specific date
                $blockedSeats=array();
                $flag = 'true';
               // $viewSeat = $this->viewSeatsRepository->getSeatInfo($busId,$blockedSeats,$flag,$journeyDate);
           }


           $lowerBerth = Config::get('constants.LOWER_BERTH');
           $upperBerth = Config::get('constants.UPPER_BERTH');
           $viewSeat['bus']=$busRecord= $this->viewSeatsRepository->busRecord($busId);
           // Lower Berth seat Calculation
           $viewSeat['lower_berth']=$this->viewSeatsRepository->getBerth($busRecord[0]->bus_seat_layout_id,$lowerBerth,$flag,$busId,$blockedSeats);
   
           if(($viewSeat['lower_berth'])->isEmpty()){
               unset($viewSeat['lower_berth']);  
               
           }else{
               $rowsColumns = $this->viewSeatsRepository->seatRowColumn($busRecord[0]->bus_seat_layout_id, $lowerBerth);

               $viewSeat['lowerBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
               $viewSeat['lowerBerth_totalColumns']=$rowsColumns->max('colNumber')+1; 
           } 
           // Upper Berth seat Calculation
           $viewSeat['upper_berth']=$this->viewSeatsRepository->getBerth($busRecord[0]->bus_seat_layout_id,$upperBerth,$flag,$busId,$blockedSeats);
   
           if(($viewSeat['upper_berth'])->isEmpty()){
               unset($viewSeat['upper_berth']); 
           }else{
               $rowsColumns = $this->viewSeatsRepository->seatRowColumn($busRecord[0]->bus_seat_layout_id, $upperBerth);
               
               $viewSeat['upperBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
               $viewSeat['upperBerth_totalColumns']=$rowsColumns->max('colNumber')+1;  
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

    public function getPriceOnSeatsSelection(Request $request)
    {

        $seaterIds = (isset($request['seater'])) ? $request['seater'] : [];
        $sleeperIds = (isset($request['sleeper'])) ? $request['sleeper'] : [];
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busOperatorId = $request['busOperatorId'];

        $busWithTicketPrice = $this->viewSeatsRepository->busWithTicketPrice($sourceId, $destinationId,$busId);
        $seaterPrice = $busWithTicketPrice->base_seat_fare;
        $sleeperPrice = $busWithTicketPrice->base_sleeper_fare;
        
        $ownerFare = count($seaterIds)*$busWithTicketPrice->base_seat_fare+
                     count($sleeperIds)*$busWithTicketPrice->base_sleeper_fare;
                    
        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($busOperatorId);
        
        foreach($ticketFareSlabs as $ticketFareSlab){

            $startingFare = $ticketFareSlab->starting_fare;
            $uptoFare = $ticketFareSlab->upto_fare;
            if($startingFare <= $ownerFare && $uptoFare >= $ownerFare){
                $percentage = $ticketFareSlab->odbus_commision;
                $odbusServiceCharges = round($ownerFare * ($percentage/100));
                $odbusCharges = $this->viewSeatsRepository->odbusCharges();
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
    public function getBoardingDroppingPoints(Request $request)
    {
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $Records =  $this->viewSeatsRepository->busStoppageTiming($busId);

        $boardingDroppings = array(); 
        if($Records) {
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
       }else{
           return '';
       }
    }

}