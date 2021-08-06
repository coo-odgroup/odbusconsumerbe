<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\BusOperator;
use App\Models\BoardingDroping;
use App\Models\BusStoppageTiming;
use App\Models\BusType;
use App\Models\BusClass;
use App\Models\SeatClass;
use App\Models\Amenities;
use App\Models\BusSeats;
use App\Models\Seats;
use App\Models\CancellationSlab;
use App\Models\CancellationSlabInfo;
use App\Models\BusContacts;
use App\Models\TicketPrice;
use App\Models\BusScheduleDate;
use App\Models\BusSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

use DateTime;
use Illuminate\Support\Facades\Log;
use DB;

class ListingRepository
{
    protected $bus;
    protected $location;
    protected $busOperator;
    protected $busStoppageTiming;
    protected $busType;
    protected $busClass;
    protected $seatClass;
    protected $amenities;
    protected $boardingDroping;
    protected $busSeats;
    protected $ticketPrice;
    protected $busScheduledate;
    protected $busSchedule;
    
    public function __construct(Bus $bus,Location $location,BusOperator $busOperator,BusStoppageTiming $busStoppageTiming,BusType $busType,Amenities $amenities,BoardingDroping $boardingDroping,BusClass $busClass,SeatClass $seatClass,BusSeats $busSeats,TicketPrice $ticketPrice,BusScheduleDate $busScheduleDate,BusSchedule $busSchedule)
    {
        $this->bus = $bus;
        $this->location = $location;
        $this->busOperator = $busOperator;
        $this->busStoppageTiming = $busStoppageTiming;
        $this->busType = $busType;
        $this->amenities = $amenities;
        $this->boardingDroping = $boardingDroping;
        $this->busClass = $busClass;
        $this->seatClass = $seatClass; 
        $this->ticketPrice = $ticketPrice;
        $this->busScheduleDate = $busScheduleDate;
        $this->busSchedule = $busSchedule;
     }   

     public function getLocation($request)
     {
        $searchValue = $request['locationName'];
         return $this->location
         ->where('name', 'like', '%' .$searchValue . '%')
         ->where('status','1')  
         ->orWhere('synonym', 'like', '%' .$searchValue . '%')
         ->orderBy('name','ASC')
         ->where('status','1')  
         ->get(['id','name','synonym']);
     }
 
    public function getAll($request)
    { 
        $source = $request['source'];
        $destination = $request['destination'];
        $entry_date = $request['entry_date'];
        $entry_date = date("Y-m-d", strtotime($entry_date));

        $sourceID =  $this->location->where("name", $source)->get('id');
        $destinationID =  $this->location->where("name", $destination)->get('id');
        if($sourceID->count()==0|| $destinationID->count()==0)
           return "";
        $sourceID =  $this->location->where("name", $source)->first()->id;
        $destinationID =  $this->location->where("name", $destination)->first()->id;    

       
        $busDetails = $this->ticketPrice
                ->where('source_id', $sourceID)
                ->where('destination_id', $destinationID)->get(['bus_id','start_j_days']);  
        $busRecords = array();
        $records = array();
        $ListingRecords = array();
        foreach($busDetails as $busDetail){
           
            $busId = $busDetail['bus_id'];
            $jdays = $busDetail['start_j_days'];

            $busRecords[] = $busId;
            
            $busScheduleDate = $this->busSchedule->whereIn('bus_id', (array)$busId)->pluck('id');
            $dates = $this->busScheduleDate
                ->where('bus_schedule_id', $busScheduleDate)           
                ->pluck('entry_date')->toarray();

            if($jdays>1){
                $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
            }else{
                $new_date = $entry_date;
            }

            if(in_array($new_date, $dates))
            {
    
                $records[] = $this->bus
                ->with('busContacts')
                ->with('busOperator')       
                ->with('busAmenities.amenities')
                ->with('busSafety.safety')
                ->with('BusType.busClass')
                ->with('busSeats.seats')
                ->with('BusSitting')
                ->with('busGallery')
                ->with('cancelationSlab')
                ->where('status','1')
                ->where('id',$busId)
                ->get();
            }   
    }
     $records = Arr::flatten($records);
     //return $records;
    
        foreach($records as $record){
            $busId = $record->id; 
            $busName = $record->name;
            $popularity = $record->popularity;
            $busNumber = $record->bus_number;
            $via = $record->via;
            $conductor_number = $record->busContacts->phone;
            $operatorId = $record->busOperator->id;
            $operatorName = $record->busOperator->operator_name;
            $sittingType = $record->BusSitting->name;   
            $busType = $record->BusType->busClass->class_name;
            $busTypeName = $record->BusType->name;
            $ticketPriceDatas = $record->ticketPrice;

            //$ticketPriceId = $ticketPriceDatas->find()->id;

            $ticketPriceRecords = $ticketPriceDatas
                    ->where('source_id', $sourceID)
                    ->where('destination_id', $destinationID)
                    ->first(); 
            $ticketPriceId = $ticketPriceRecords->id;
            $startingFromPrice = $ticketPriceRecords->base_seat_fare;
            $departureTime = $ticketPriceRecords->dep_time;
            $arrivalTime = $ticketPriceRecords->arr_time;
            $depTime = date("H:i",strtotime($departureTime));
            $arrTime = date("H:i",strtotime($arrivalTime)); 
            $arr_time = new DateTime($arrivalTime);
            $dep_time = new DateTime($departureTime);
            $totalTravelTime = $dep_time->diff($arr_time);
            $totalJourneyTime = ($totalTravelTime->format("%a") * 24) + $totalTravelTime->format(" %h"). "h". $totalTravelTime->format(" %im");

            $totalSeats = $record->busSeats->where('ticket_price_id',$ticketPriceId)->where('bookStatus','0')->count('id');
            //$totalSeats = $record->busSeats->where('ticket_price_id',$ticketPriceId)->count('id');
            $seatDatas = $record->busSeats->where('ticket_price_id',$ticketPriceId)->all();
            $amenityDatas = $record->busAmenities;
            $amenityName = $amenityDatas->pluck('amenities.name');
            $amenityIcon = $amenityDatas->pluck('amenities.icon');
            $safetyDatas = $record->busSafety;
            $safetyName = $safetyDatas->pluck('safety.name');
            $safetyIcon = $safetyDatas->pluck('safety.icon');
            $busPhotoDatas = $record->busGallery;
            $busPhotos = $busPhotoDatas->pluck('image');

             $seatClassRecords = 0;
             $sleeperClassRecords = 0;
            foreach($seatDatas as $seatData) {  
                 $seatclass = $seatData->seats->seat_class_id;
                 if($seatclass==1){
                     $seatClassRecords ++;
                 }
                 elseif($seatclass==2 || $seatclass==3){
                     $sleeperClassRecords ++;
                }
            }
            $ListingRecords[] = array(
                "busId" => $busId, 
                "busName" => $busName,
                "popularity" => $popularity,
                "busNumber" => $busNumber,
                "conductor_number" => $conductor_number,
                "operatorId" => $operatorId,
                "operatorName" => $operatorName,
                "sittingType" => $sittingType,
                "busType" => $busType,
                "busTypeName" => $busTypeName,
                "totalSeats" => $totalSeats,
                "seaters" => $seatClassRecords,
                "sleepers" => $sleeperClassRecords,
                "startingFromPrice" => $startingFromPrice,
                "departureTime" =>$depTime,
                "arrivalTime" =>$arrTime,
                "totalJourneyTime" =>$totalJourneyTime,
                "amenityName" =>$amenityName,
                "amenityIcon" => $amenityIcon,
                "safetyIconName" =>$safetyName,
                "safetyIcon" => $safetyIcon,
                "busPhotos" => $busPhotos,        
            );
                    
        }
        return $ListingRecords;
    }


    public function getFilterOptions($request)
    {
        $sourceID = $request['sourceID'];
        $destinationID = $request['destinationID']; 

        $busTypes =  $this->busClass->get(['id','class_name']);
        $seatTypes = $this->seatClass->where('id',1)->orWhere('id',2)->get(['id','name']);
        $boardingPoints = $this->boardingDroping->where('location_id', $sourceID)->get(['id','boarding_point']);
        $dropingPoints = $this->boardingDroping->where('location_id', $destinationID)->get(['id','boarding_point']);
        $busOperator = $this->busOperator->get(['id','operator_name']);
        $amenities = $this->amenities->get(['id','name','icon']);

        $filterOptions[] = array(
           "busTypes" => $busTypes,
           "seatTypes" => $seatTypes,  
           "boardingPoints" => $boardingPoints,
           "dropingPoints"=> $dropingPoints,
           "busOperator"=>$busOperator,
           "amenities"=>$amenities   
        );
        return  $filterOptions;

    }

    public function filter($request)
    {      
        $price = $request['price'];
        $sourceID = $request['sourceID'];      
        $destinationID = $request['destinationID']; 
        $entry_date = $request['entry_date'];   
        if($sourceID==null ||  $destinationID==null || $entry_date==null)
            return ""; 
        $entry_date = date("Y-m-d", strtotime($entry_date));    
        $busType = $request['busType'];
        $seatType = $request['seatType'];    
        $boardingPointId = $request['boardingPointId'];
        $dropingingPointId = $request['dropingingPointId'];
        $operatorId = $request['operatorId'];
        $amenityId = $request['amenityId'];

        $busDetails = $this->ticketPrice
        ->where('source_id', $sourceID)
        ->where('destination_id', $destinationID)->get(['bus_id','start_j_days']);  
        $busRecords = array();
        $records = array();
        $ListingRecords = array();

        foreach($busDetails as $busDetail){
            $busId = $busDetail['bus_id'];
            $jdays = $busDetail['start_j_days'];
            $busRecords[] = $busId;
            $busScheduleDate = $this->busSchedule->whereIn('bus_id', (array)$busId)->pluck('id');
            $dates = $this->busScheduleDate
                ->where('bus_schedule_id', $busScheduleDate)           
                ->pluck('entry_date')->toarray();
            if($jdays>1){
                $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
            }else{
                $new_date = $entry_date;
            }
            if(in_array($new_date, $dates))
            {
                $records[] = $this->bus
                ->with('busOperator')
                ->with('busAmenities.amenities')
                ->with('busSafety.safety')
                ->with('BusType.busClass')
                ->with('busSeats.seats')
                ->with('BusSitting')
                ->with('busGallery')
                ->whereHas('busType.busClass', function ($query) use ($busType){
                    if($busType)
                    $query->whereIn('id', (array)$busType);            
                    })
                ->whereHas('busSeats.seats.seatClass', function ($query) use ($seatType){
                    if($seatType)
                    $query->whereIn('id', (array)$seatType);            
                    })
                ->whereHas('busStoppageTiming.boardingDroping', function ($query) use ($boardingPointId){  
                    if($boardingPointId)                   
                    $query->whereIn('id', (array)$boardingPointId);
                      })    
                ->whereHas('busStoppageTiming.boardingDroping', function ($query) use ($dropingingPointId){
                    if($dropingingPointId)  
                    $query->whereIn('id', (array)$dropingingPointId);
                     })       
                ->whereHas('busOperator', function ($query) use ($operatorId){
                    if($operatorId)
                    $query->whereIn('id', (array)$operatorId);            
                    })
                ->whereHas('busAmenities.amenities', function ($query) use ($amenityId){
                    if($amenityId)
                    $query->whereIn('id', (array)$amenityId);            
                    })  
                ->where('id',$busId)
                ->get();
            }   
        }
        $records = Arr::flatten($records); 
            $FilterRecords = array();
            foreach($records as $record){
                $busId = $record->id; 
                $busName = $record->name;
                $popularity = $record->popularity;
                $busNumber = $record->bus_number;
                $via = $record->via;
                $conductor_number = $record->busContacts->phone;
                $operatorId = $record->busOperator->id;
                $operatorName = $record->busOperator->operator_name;
                $sittingType = $record->BusSitting->name;
                $busType = $record->BusType->busClass->class_name;
                $busTypeName = $record->BusType->name;
                $ticketPriceDatas = $record->ticketPrice;
                $ticketPriceRecords = $ticketPriceDatas
                ->where('source_id', $sourceID)
                ->where('destination_id', $destinationID)
                ->first(); 
                $ticketPriceId = $ticketPriceRecords->id;
                $startingFromPrice = $ticketPriceRecords->base_seat_fare;
                $departureTime = $ticketPriceRecords->dep_time;
                $arrivalTime = $ticketPriceRecords->arr_time;
                $depTime = date("H:i",strtotime($departureTime));
                $arrTime = date("H:i",strtotime($arrivalTime)); 
                $arr_time = new DateTime($arrivalTime);
                $dep_time = new DateTime($departureTime);
                $totalTravelTime = $dep_time->diff($arr_time);
                $totalJourneyTime = ($totalTravelTime->format("%a") * 24) + $totalTravelTime->format(" %h"). "h". $totalTravelTime->format(" %im");


                $totalSeats = $record->busSeats->where('ticket_price_id',$ticketPriceId)->count('id');
                $seatDatas = $record->busSeats->where('ticket_price_id',$ticketPriceId)->all();
                $amenityDatas = $record->busAmenities;
                $amenityName = $amenityDatas->pluck('amenities.name');
                $amenityIcon = $amenityDatas->pluck('amenities.icon');
                $safetyDatas = $record->busSafety;
                $safetyName = $safetyDatas->pluck('safety.name');
                $safetyIcon = $safetyDatas->pluck('safety.icon');
                $busPhotoDatas = $record->busGallery;
                $busPhotos = $busPhotoDatas->pluck('image');
                 $seatClassRecords = 0;
                 $sleeperClassRecords = 0;
                foreach($seatDatas as $seatData) {  
                     $seatclass = $seatData->seats->seat_class_id;
                     if($seatclass==1){
                         $seatClassRecords ++;
                     }
                     elseif($seatclass==2 || $seatclass==3){
                         $sleeperClassRecords ++;
                    }
                }
                $FilterRecords[] = array(
                    "busId" => $busId, 
                    "busName" => $busName,
                    "popularity" => $popularity,
                    "busNumber" => $busNumber, 
                    "conductor_number" => $conductor_number,
                    "operatorId" => $operatorId,
                    "operatorName" => $operatorName,
                    "sittingType" => $sittingType,
                    "busType" => $busType,
                    "busTypeName" => $busTypeName,
                    "totalSeats" => $totalSeats,
                    "seaters" => $seatClassRecords,
                    "sleepers" => $sleeperClassRecords,
                    "startingFromPrice" => $startingFromPrice,
                    "departureTime" =>$depTime,
                    "arrivalTime" =>$arrTime,
                    "totalJourneyTime" =>$totalJourneyTime,
                    "amenityName" =>$amenityName,
                    "amenityIcon" => $amenityIcon, 
                    "safetyIconName" =>$safetyName,
                    "safetyIcon" => $safetyIcon,
                    "busPhotos" => $busPhotos,     
                );            
            }
            if($price == 0){
                $sorted = $FilterRecords;  
            }elseif($price == 1){
                $sortByPrice = collect($FilterRecords)->sortBy('startingFromPrice')->all();
                $sorted = $sortByPrice; 
           }
            
           $sorted = array_values($sorted);
           return $sorted;   
    
    }

}