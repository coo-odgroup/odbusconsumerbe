<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Bus;
use App\Repositories\ViewSeatsRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Illuminate\Support\Arr;
use App\Models\TicketPrice;
use App\Models\BusSeats;
use App\Models\SpecialFare;
use App\Models\BusSpecialFare;
use App\Models\OwnerFare;
use App\Models\BusOwnerFare;


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
        $lowerBerth = Config::get('constants.LOWER_BERTH');
        $upperBerth = Config::get('constants.UPPER_BERTH');

        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];
        $busId = $request['busId'];
        $journeyDate = $request['entry_date'];
        $journeyDate = date("Y-m-d", strtotime($journeyDate));

        $miscfares = $this->viewSeatsRepository->miscFares($busId,$journeyDate);

        $requestedSeq = $this->viewSeatsRepository->busLocationSequence($sourceId,$destinationId,$busId);

        $reqRange = Arr::sort($requestedSeq);
        $bookingIds = $this->viewSeatsRepository->bookingIds($busId,$journeyDate,$booked,$seatHold,$sourceId,$destinationId);
        
        if (sizeof($bookingIds)){
            $blockedSeats=array();
            foreach($bookingIds as $bookingId){
                $seatsIds = array();
                $bookedSeatIds = $this->viewSeatsRepository->bookingDetail($bookingId);
                foreach($bookedSeatIds as $bookedSeatId){
                    $seatsIds[] = $this->viewSeatsRepository->busSeats($bookedSeatId);
                    $gender[] = $this->viewSeatsRepository->bookingGenderDetail($bookingId,$bookedSeatId);     
                }   
                 $srcId=  $this->viewSeatsRepository->getSourceId($bookingId);
                 $destId=  $this->viewSeatsRepository->getDestinationId($bookingId);
                 $bookedSequence = $this->viewSeatsRepository->bookedSequence($srcId,$destId,$busId);
                 $bookedRange = Arr::sort($bookedSequence);

                //seat available on requested seq so blocked seats are none.
                if((last($reqRange)<=head($bookedRange)) || (last($bookedRange)<=head($reqRange))){
                    $blockedSeats=array();
                    
                }
                else{   //seat not available on requested seq so blocked seats are calculated   
                    $blockedSeats = array_merge($blockedSeats,$seatsIds);
                } 
            }
        }else{          //no booking on that specific date, so all seats are available
                $blockedSeats=array();
        }

           $lowerBerth = Config::get('constants.LOWER_BERTH');
           $upperBerth = Config::get('constants.UPPER_BERTH');
           $viewSeat['bus']=$busRecord= $this->viewSeatsRepository->busRecord($busId);


           // Lower Berth seat Calculation
           $viewSeat['lower_berth']=$this->viewSeatsRepository->getBerth($busRecord[0]->bus_seat_layout_id,$lowerBerth,$busId,$blockedSeats,$journeyDate,$sourceId,$destinationId);
            //return $viewSeat;
           if(($viewSeat['lower_berth'])->isEmpty()){
               unset($viewSeat['lower_berth']);  
           }else{
               $rowsColumns = $this->viewSeatsRepository->seatRowColumn($busRecord[0]->bus_seat_layout_id, $lowerBerth);

               $viewSeat['lowerBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
               $viewSeat['lowerBerth_totalColumns']=$rowsColumns->max('colNumber')+1; 
           } 
          // Upper Berth seat Calculation
           $viewSeat['upper_berth']=$this->viewSeatsRepository->getBerth($busRecord[0]->bus_seat_layout_id,$upperBerth,$busId,$blockedSeats,$journeyDate,$sourceId,$destinationId);
        
           if(($viewSeat['upper_berth'])->isEmpty()){
               unset($viewSeat['upper_berth']); 
           }else{
               $rowsColumns = $this->viewSeatsRepository->seatRowColumn($busRecord[0]->bus_seat_layout_id, $upperBerth);
               
               $viewSeat['upperBerth_totalRows']=$rowsColumns->max('rowNumber')+1;       
               $viewSeat['upperBerth_totalColumns']=$rowsColumns->max('colNumber')+1;  
           }
                // Add Gender into Booked seat List
                    $i=0; 
                    if(isset($viewSeat['upper_berth'])){  
                      foreach($viewSeat['upper_berth'] as &$ub){
                        if(collect($ub)->has(['bus_seats'])){
                        // if(isset($ub->busSeats)){
                            $ub->busSeats->ticket_price = $this->viewSeatsRepository->busWithTicketPrice($sourceId,$destinationId,$busId);

                            $ub->busSeats->ticket_price->base_sleeper_fare+=$miscfares[1]+ $miscfares[3]+ $miscfares[5];
                            if($ub->busSeats->new_fare > 0){
                                $ub->busSeats->new_fare +=$miscfares[1]+ $miscfares[3]+ $miscfares[5];
                            }   
                        }
                        if (sizeof($bookingIds)){
                            if(in_array($ub['id'], $blockedSeats)){
                            //if(collect($blockedSeats)->has($ub['id'])){
                                $key = array_search($ub['id'], $seatsIds);
                                $viewSeat['upper_berth'][$i]['Gender'] =  $gender[$key];
                            } 
                        }
                        $i++;
                       }     
                    } 
                    $i=0;
                    if(isset($viewSeat['lower_berth'])){          
                      foreach($viewSeat['lower_berth'] as &$lb){    
                        if(collect($lb)->has(['bus_seats'])){                  
                        // if(isset($lb->busSeats)){                           
                            $lb->busSeats->ticket_price = $this->viewSeatsRepository->busWithTicketPrice($sourceId,$destinationId,$busId);
                            $lb->busSeats->ticket_price->base_seat_fare+=$miscfares[0]+ $miscfares[2]+ $miscfares[4];
                            if($lb->busSeats->new_fare > 0){
                                $lb->busSeats->new_fare +=$miscfares[0]+ $miscfares[2]+ $miscfares[4];
                            }   
                        }
                        if (sizeof($bookingIds)){    
                            if(in_array($lb['id'], $blockedSeats)){
                                $key = array_search($lb['id'], $seatsIds);
                                $viewSeat['lower_berth'][$i]['Gender'] = $gender[$key];
                            } 
                        }
                        $i++;
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
        $entry_date = $request['entry_date'];
        $entry_date = date("Y-m-d", strtotime($entry_date));
        //$busOperatorId = $request['busOperatorId'];
        $user_id = Bus::where('id', $busId)->first()->user_id;

        $miscfares = $this->viewSeatsRepository->miscFares($busId,$entry_date);

        $busWithTicketPrice = $this->viewSeatsRepository->busWithTicketPrice($sourceId, $destinationId,$busId);
        $ticket_new_fare=array();
        if($seaterIds){
            $ticket_new_fare[] = $this->viewSeatsRepository->newFare($seaterIds,$busId,$busWithTicketPrice->id);
        }             
        if($sleeperIds){
            $ticket_new_fare[] = $this->viewSeatsRepository->newFare($sleeperIds,$busId,$busWithTicketPrice->id);   
        }

        $ownerFare=0;
        $totalSplFare =0;
        $totalOwnFare =0;
        $totalFestiveFare =0;
        $PriceDetail=[];
        if(count($ticket_new_fare) > 0){
            foreach($ticket_new_fare as $tktprc){
                foreach($tktprc as $tkt){
                    if( $tkt->type==2 || ($tkt->type==null && $tkt->operation_date != null )){
                        // do nothing (this logic is to avoid extra seat block , seat block seats )
                    }  else{
                        if($tkt->new_fare == 0 ){
                            if($seaterIds && in_array($tkt->seats_id,$seaterIds)){
                                $tkt->new_fare = $busWithTicketPrice->base_seat_fare;
                            }
                            else if($sleeperIds && in_array($tkt->seats_id,$sleeperIds)){
                                $tkt->new_fare = $busWithTicketPrice->base_sleeper_fare;
                            }
                            array_push($PriceDetail,$tkt);
                        }
                        if($seaterIds && in_array($tkt->seats_id,$seaterIds)){
                            $totalSplFare +=$miscfares[0];
                            $totalOwnFare +=$miscfares[2];
                            $totalFestiveFare +=$miscfares[4];
                            $tkt->new_fare +=$miscfares[0]+$miscfares[2]+$miscfares[4]; 
                        }
                        else if($sleeperIds && in_array($tkt->seats_id,$sleeperIds)){
                            $totalSplFare +=$miscfares[1];
                            $totalOwnFare +=$miscfares[3];
                            $totalFestiveFare +=$miscfares[5];
                            $tkt->new_fare +=$miscfares[1]+$miscfares[3]+$miscfares[5]; 
                        }
                        $ownerFare +=$tkt->new_fare;            
                    }       
                }  
            }
        }
       // $seaterPrice = $busWithTicketPrice->base_seat_fare;
       // $sleeperPrice = $busWithTicketPrice->base_sleeper_fare;
       // $ownerFare = count($seaterIds)*$busWithTicketPrice->base_seat_fare+
       //              count($sleeperIds)*$busWithTicketPrice->base_sleeper_fare;             
        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
        $odbusServiceCharges = 0;
        $transactionFee = 0;
        $totalFare = $ownerFare; 
        foreach($ticketFareSlabs as $ticketFareSlab){

            $startingFare = $ticketFareSlab->starting_fare;
            $uptoFare = $ticketFareSlab->upto_fare;
            if($startingFare <= $ownerFare && $uptoFare >= $ownerFare){
                $percentage = $ticketFareSlab->odbus_commision;
                $odbusServiceCharges = round($ownerFare * ($percentage/100));
                $odbusCharges = $this->viewSeatsRepository->odbusCharges($user_id);
                $smsEmailCharges = $odbusCharges[0]->email_sms_charges;
                $gwPercentage = ($odbusCharges[0]->payment_gateway_charges)/100;
                $gwCharges = (($ownerFare + $odbusServiceCharges + $smsEmailCharges) * $gwPercentage);
                $transactionFee = round($smsEmailCharges + $gwCharges);
                $totalFare = round($ownerFare + $odbusServiceCharges + $transactionFee);
                }     
            }  
        // $seatWithPriceRecords[] = array(
        //     "seaterPrice" => $seaterPrice,
        //     "sleeperPrice" => $sleeperPrice,
        //     "ownerFare" => $ownerFare,
        //     "odbusServiceCharges" => $odbusServiceCharges,
        //     "transactionFee" => $transactionFee,
        //     "totalFare" => $totalFare,
        //     ); 

            $seatWithPriceRecords[] = array(
                "PriceDetail" => $PriceDetail,
                "ownerFare" => $ownerFare,
                "specialFare" => $totalSplFare,
                "addOwnerFare" => $totalOwnFare,
                "festiveFare" => $totalFestiveFare,
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

        //Log::info($Records);
        $boardingArray=[];
        $droppingArray=[];

        $boardingDroppings = array(); 
        if($Records) {
        foreach($Records as $Record){  
            if($Record->boardingDroping != null){
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