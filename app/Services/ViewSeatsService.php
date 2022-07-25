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
    public function getAllViewSeats($request,$clientRole)
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

        $user_id = Bus::where('id', $busId)->first()->user_id;

        $miscfares = $this->viewSeatsRepository->miscFares($busId,$journeyDate);

        $requestedSeq = $this->viewSeatsRepository->busLocationSequence($sourceId,$destinationId,$busId);

        $reqRange = Arr::sort($requestedSeq);
        $bookingIds = $this->viewSeatsRepository->bookingIds($busId,$journeyDate,$booked,$seatHold,$sourceId,$destinationId);

        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
        
        if (sizeof($bookingIds)){
            $blockedSeats=array();
            foreach($bookingIds as $bookingId){
                //$seatsIds = array();
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
                // if((last($reqRange)<=head($bookedRange)) || (last($bookedRange)<=head($reqRange))){
                //    //$blockedSeats=array();
                    
                // }
                // else{   //seat not available on requested seq so blocked seats are calculated   
                //     $blockedSeats = array_merge($blockedSeats,$seatsIds);
                // } 

                //seat not available on requested seq so blocked seats are calculated 
                if((last($reqRange)>head($bookedRange)) || (last($bookedRange)>($reqRange))){
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
                            
                            $base_sleeper_fare=$ub->busSeats->ticket_price->base_sleeper_fare;

                            /////////// add odbus gst to seat fare

                            $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
                            $odbusServiceCharges = 0;
                            foreach($ticketFareSlabs as $ticketFareSlab){
                                $startingFare = $ticketFareSlab->starting_fare;
                                $uptoFare = $ticketFareSlab->upto_fare;
                                if($startingFare <= $base_sleeper_fare && $uptoFare >= $base_sleeper_fare){
                                    $percentage = $ticketFareSlab->odbus_commision;
                                    $odbusServiceCharges = round($base_sleeper_fare * ($percentage/100));
                                    $ub->busSeats->ticket_price->base_sleeper_fare = round($base_sleeper_fare + $odbusServiceCharges);
                                    }     
                                }

                           //////////////////////////////////////////////////////////////

                            if($ub->busSeats->new_fare > 0){
                                $ub->busSeats->new_fare +=$miscfares[1]+ $miscfares[3]+ $miscfares[5];
                                $new_fare=$ub->busSeats->new_fare;

                                /////////// add odbus gst to seat fare

                         
                            $odbusServiceCharges = 0;
                            foreach($ticketFareSlabs as $ticketFareSlab){
                                $startingFare = $ticketFareSlab->starting_fare;
                                $uptoFare = $ticketFareSlab->upto_fare;
                                if($startingFare <= $new_fare && $uptoFare >= $new_fare){
                                    $percentage = $ticketFareSlab->odbus_commision;
                                    $odbusServiceCharges = round($new_fare * ($percentage/100));
                                    $ub->busSeats->new_fare = round($new_fare + $odbusServiceCharges);
                                    }     
                                }

                           //////////////////////////////////////////////////////////////

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

                            $base_seat_fare=$lb->busSeats->ticket_price->base_seat_fare;
                            /////////// add odbus gst to seat fare
                            $odbusServiceCharges = 0;
                            foreach($ticketFareSlabs as $ticketFareSlab){
                                $startingFare = $ticketFareSlab->starting_fare;
                                $uptoFare = $ticketFareSlab->upto_fare;
                                if($startingFare <= $base_seat_fare && $uptoFare >= $base_seat_fare){
                                    $percentage = $ticketFareSlab->odbus_commision;
                                    $odbusServiceCharges = round($base_seat_fare * ($percentage/100));
                                    $lb->busSeats->ticket_price->base_seat_fare = round($base_seat_fare + $odbusServiceCharges);
                                    }     
                                }

                            if($lb->busSeats->new_fare > 0){
                                $lb->busSeats->new_fare +=$miscfares[0]+ $miscfares[2]+ $miscfares[4];

                               $new_fare= $lb->busSeats->new_fare;

                                 /////////// add odbus gst to seat fare

                            $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
                            $odbusServiceCharges = 0;
                            foreach($ticketFareSlabs as $ticketFareSlab){
                                $startingFare = $ticketFareSlab->starting_fare;
                                $uptoFare = $ticketFareSlab->upto_fare;
                                if($startingFare <= $new_fare && $uptoFare >= $new_fare){
                                    $percentage = $ticketFareSlab->odbus_commision;
                                    $odbusServiceCharges = round($new_fare * ($percentage/100));
                                    $lb->busSeats->new_fare = round($new_fare + $odbusServiceCharges);
                                    }     
                                }           
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
             //$viewSeat = collect($viewSeat);
        //////////////////////////////////////////////////////////////////////////////////////
            $clientRoleId = Config::get('constants.CLIENT_ROLE_ID');
            if($clientRole == $clientRoleId){
                $viewSeat->forget('ticket_price');
                return $viewSeat;
            }else{
                return $viewSeat;
            }


        ///////////////////////////////////////////////////////////////////////////////////////////

    }

    public function getPriceOnSeatsSelection(Request $request,$clientRole)
    {
        $clientRoleId = Config::get('constants.CLIENT_ROLE_ID');
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

        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);

        $ownerFare=0;
        $odbus_charges_ownerFare=0;
        $totalSplFare =0;
        $totalOwnFare =0;
        $totalFestiveFare =0;
        $PriceDetail=[];
        $service_charges=0;
 
        if(count($ticket_new_fare) > 0){
            foreach($ticket_new_fare as $tktprc){
                foreach($tktprc as $tkt){
                    if( $tkt->type==2 || ($tkt->type==null && $tkt->operation_date != null )){
                        // do nothing (this logic is to avoid extra seat block , seat block seats )
                    }  else{
                        if($tkt->operation_date== $entry_date || $tkt->operation_date==null ){
                           
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
                            $seat_fare=$tkt->new_fare;
                            $ownerFare +=$tkt->new_fare;
                            ////////// add odbus service chanrges to seat fare
    
                            $odbusServiceCharges = 0;
                            foreach($ticketFareSlabs as $ticketFareSlab){
                    
                                $startingFare = $ticketFareSlab->starting_fare;
                                $uptoFare = $ticketFareSlab->upto_fare;
                                if($startingFare <= $seat_fare && $uptoFare >= $seat_fare){
                                    $percentage = $ticketFareSlab->odbus_commision;
                                    $odbusServiceCharges = round($seat_fare * ($percentage/100));                                
                                    $tkt->new_fare = round($seat_fare + $odbusServiceCharges);
                                    $service_charges += $odbusServiceCharges;
                                    }     
                                } 
                            $odbus_charges_ownerFare +=$tkt->new_fare; 
                        }                         
                    }       
                }  
            }
        }
        $odbusServiceCharges = 0;
        $transactionFee = 0;
        $totalFare = $odbus_charges_ownerFare; 

        $odbusCharges = $this->viewSeatsRepository->odbusCharges($user_id);
        $gwCharges = $odbusCharges[0]->payment_gateway_charges + $odbusCharges[0]->email_sms_charges;
        $transactionFee = round(($odbus_charges_ownerFare * $gwCharges)/100,2);
        $totalFare = round($odbus_charges_ownerFare + $transactionFee,2);

        if($clientRole == $clientRoleId){
            $seatWithPriceRecords[] = array(
                "totalFare" => $odbus_charges_ownerFare
                ); 
        }else{
            $seatWithPriceRecords[] = array(
                "PriceDetail" => $PriceDetail,
                "ownerFare" => $ownerFare,
                "odbus_charges_ownerFare" => $odbus_charges_ownerFare,
                "specialFare" => $totalSplFare,
                "addOwnerFare" => $totalOwnFare,
                "festiveFare" => $totalFestiveFare,
                "odbusServiceCharges" => $service_charges,
                "transactionFee" => $transactionFee,
                "totalFare" => $totalFare
                );    
        }
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

    //////////////////used for client API booking///////////////

public function getPriceCalculation($request)
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
    $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);

    $ownerFare=0;
    $odbus_charges_ownerFare=0;
    $totalSplFare =0;
    $totalOwnFare =0;
    $totalFestiveFare =0;
    $PriceDetail=[];
    $service_charges=0;
    $tktprc = Arr::flatten($ticket_new_fare);

    $collectionSeater = collect($seaterIds);
    $collectionSleeper = collect($sleeperIds);

    if(count($tktprc) > 0){
            foreach($tktprc as $tkt){
                if( $tkt->type==2 || ($tkt->type==null && $tkt->operation_date != null )){
                    // do nothing (this logic is to avoid extra seat block , seat block seats )
                }  else{
                    if($tkt->operation_date== $entry_date || $tkt->operation_date==null ){
                        
                        if($tkt->new_fare == 0 ){
 
                            if($collectionSeater && $collectionSeater->contains($tkt->seats_id))
                            {
                                $tkt->new_fare = $busWithTicketPrice->base_seat_fare;
                            }

                            else if($collectionSleeper && $collectionSleeper->contains($tkt->seats_id))
                            {
                                $tkt->new_fare = $busWithTicketPrice->base_sleeper_fare;
                            }
                           
                            array_push($PriceDetail,$tkt);
                        }
                        
                        if($collectionSeater && $collectionSeater->contains($tkt->seats_id)){
                           
                            $totalSplFare +=$miscfares[0];
                            $totalOwnFare +=$miscfares[2];
                            $totalFestiveFare +=$miscfares[4];
                            $tkt->new_fare +=$miscfares[0]+$miscfares[2]+$miscfares[4]; 
                        }
                        else if($collectionSleeper && $collectionSleeper->contains($tkt->seats_id)){
                            
                            $totalSplFare +=$miscfares[1];
                            $totalOwnFare +=$miscfares[3];
                            $totalFestiveFare +=$miscfares[5];
                            $tkt->new_fare +=$miscfares[1]+$miscfares[3]+$miscfares[5]; 
                        }
                      
                        $seat_fare=$tkt->new_fare;
                        $ownerFare +=$tkt->new_fare;

                        ////////// add odbus service chanrges to seat fare

                        $odbusServiceCharges = 0;
                        foreach($ticketFareSlabs as $ticketFareSlab){
                
                            $startingFare = $ticketFareSlab->starting_fare;
                            $uptoFare = $ticketFareSlab->upto_fare;
                            if($startingFare <= $seat_fare && $uptoFare >= $seat_fare){
                                $percentage = $ticketFareSlab->odbus_commision;
                                $odbusServiceCharges = round($seat_fare * ($percentage/100));                                
                                $tkt->new_fare = round($seat_fare + $odbusServiceCharges);
                                $service_charges += $odbusServiceCharges;
                                }     
                            } 
                        $odbus_charges_ownerFare +=$tkt->new_fare; 
                    }                        
                }       
            }  
    }
    $transactionFee = 0;
    $totalFare = $odbus_charges_ownerFare; 

    $odbusCharges = $this->viewSeatsRepository->odbusCharges($user_id);
    $gwCharges = $odbusCharges[0]->payment_gateway_charges + $odbusCharges[0]->email_sms_charges;
    $transactionFee = round(($odbus_charges_ownerFare * $gwCharges)/100,2);
    $totalFare = round($odbus_charges_ownerFare + $transactionFee,2);

    $seatWithPriceRecords[] = array(
            "PriceDetail" => $PriceDetail,
            "ownerFare" => $ownerFare,
            "odbus_charges_ownerFare" => $odbus_charges_ownerFare,
            "specialFare" => $totalSplFare,
            "addOwnerFare" => $totalOwnFare,
            "festiveFare" => $totalFestiveFare,
            "odbusServiceCharges" => $service_charges,
            "transactionFee" => $transactionFee,
            "totalFare" => $totalFare
            ); 

    return $seatWithPriceRecords;
    
}
/////////////for client api use///////////////////
public function checkSeatStatus($request)
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

    $user_id = Bus::where('id', $busId)->first()->user_id;
    $miscfares = $this->viewSeatsRepository->miscFares($busId,$journeyDate);
    $requestedSeq = $this->viewSeatsRepository->busLocationSequence($sourceId,$destinationId,$busId);

    $reqRange = Arr::sort($requestedSeq);
    $bookingIds = $this->viewSeatsRepository->bookingIds($busId,$journeyDate,$booked,$seatHold,$sourceId,$destinationId);

    $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
    
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
             $bookedSequence = $this->viewSeatsRepository->bookedSequence($srcId,$destId,$busId);
             $bookedRange = Arr::sort($bookedSequence);

            //seat not available on requested seq so blocked seats are calculated 
            if((last($reqRange)>head($bookedRange)) || (last($bookedRange)>($reqRange))){
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
                        
                        $base_sleeper_fare=$ub->busSeats->ticket_price->base_sleeper_fare;

                        /////////// add odbus gst to seat fare

                        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
                        $odbusServiceCharges = 0;
                        foreach($ticketFareSlabs as $ticketFareSlab){
                            $startingFare = $ticketFareSlab->starting_fare;
                            $uptoFare = $ticketFareSlab->upto_fare;
                            if($startingFare <= $base_sleeper_fare && $uptoFare >= $base_sleeper_fare){
                                $percentage = $ticketFareSlab->odbus_commision;
                                $odbusServiceCharges = round($base_sleeper_fare * ($percentage/100));
                                $ub->busSeats->ticket_price->base_sleeper_fare = round($base_sleeper_fare + $odbusServiceCharges);
                                }     
                            }
                        if($ub->busSeats->new_fare > 0){
                            $ub->busSeats->new_fare +=$miscfares[1]+ $miscfares[3]+ $miscfares[5];
                            $new_fare=$ub->busSeats->new_fare;

                            /////////// add odbus gst to seat fare
                        $odbusServiceCharges = 0;
                        foreach($ticketFareSlabs as $ticketFareSlab){
                            $startingFare = $ticketFareSlab->starting_fare;
                            $uptoFare = $ticketFareSlab->upto_fare;
                            if($startingFare <= $new_fare && $uptoFare >= $new_fare){
                                $percentage = $ticketFareSlab->odbus_commision;
                                $odbusServiceCharges = round($new_fare * ($percentage/100));
                                $ub->busSeats->new_fare = round($new_fare + $odbusServiceCharges);
                                }     
                            }
                        }   
                    }
                    if (sizeof($bookingIds)){
                        if(in_array($ub['id'], $blockedSeats)){
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
                        $lb->busSeats->ticket_price = $this->viewSeatsRepository->busWithTicketPrice($sourceId,$destinationId,$busId);
                        $lb->busSeats->ticket_price->base_seat_fare+=$miscfares[0]+ $miscfares[2]+ $miscfares[4];

                        $base_seat_fare=$lb->busSeats->ticket_price->base_seat_fare;
                        /////////// add odbus gst to seat fare
                        $odbusServiceCharges = 0;
                        foreach($ticketFareSlabs as $ticketFareSlab){
                            $startingFare = $ticketFareSlab->starting_fare;
                            $uptoFare = $ticketFareSlab->upto_fare;
                            if($startingFare <= $base_seat_fare && $uptoFare >= $base_seat_fare){
                                $percentage = $ticketFareSlab->odbus_commision;
                                $odbusServiceCharges = round($base_seat_fare * ($percentage/100));
                                $lb->busSeats->ticket_price->base_seat_fare = round($base_seat_fare + $odbusServiceCharges);
                                }     
                            }
                        if($lb->busSeats->new_fare > 0){
                            $lb->busSeats->new_fare +=$miscfares[0]+ $miscfares[2]+ $miscfares[4];

                           $new_fare= $lb->busSeats->new_fare;

                             /////////// add odbus gst to seat fare

                        $ticketFareSlabs = $this->viewSeatsRepository->ticketFareSlab($user_id);
                        $odbusServiceCharges = 0;
                        foreach($ticketFareSlabs as $ticketFareSlab){
                            $startingFare = $ticketFareSlab->starting_fare;
                            $uptoFare = $ticketFareSlab->upto_fare;
                            if($startingFare <= $new_fare && $uptoFare >= $new_fare){
                                $percentage = $ticketFareSlab->odbus_commision;
                                $odbusServiceCharges = round($new_fare * ($percentage/100));
                                $lb->busSeats->new_fare = round($new_fare + $odbusServiceCharges);
                                }     
                            }
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

}