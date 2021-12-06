<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\ListingRepository;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use DateTime;

class ListingService
{
    
    protected $listingRepository;    
    public function __construct(ListingRepository $listingRepository,CommonRepository $commonRepository)
    {
        $this->listingRepository = $listingRepository;
        $this->commonRepository = $commonRepository;
    }
    public function getAll(Request $request)
    {  
        $source = $request['source'];
        $destination = $request['destination'];
        $entry_date = $request['entry_date'];
        $busOperatorId = $request['bus_operator_id'];
        $entry_date = date("Y-m-d", strtotime($entry_date));


        $path= $this->commonRepository->getPathurls();
        $path= $path[0];

        $srcResult= $this->listingRepository->getLocationID($request['source']);
        $destResult= $this->listingRepository->getLocationID($request['destination']);

        if($srcResult->count()==0 || $destResult->count()==0)
           return "";

         $sourceID =  $srcResult[0]->id;
         $destinationID =  $destResult[0]->id;       

         $selCouponRecords = $this->listingRepository->getAllCoupon();

         $routeCoupon = $this->listingRepository->getrouteCoupon($sourceID,$destinationID);

         if(isset($routeCoupon[0]->coupon)){                           
            $routeCouponCode = $routeCoupon[0]->coupon->coupon_code;//route wise coupon
         }else{
            $routeCouponCode =[];
         }         
         
         $busDetails = $this->listingRepository->getticketPrice($sourceID,$destinationID,$busOperatorId);  
       
         $records = array();
         $ListingRecords = array();
         foreach($busDetails as $busDetail){
             $busId = $busDetail['bus_id'];
             $jdays = $busDetail['start_j_days'];

             if($jdays>1){
                $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
            }else{
                $new_date = $entry_date;
            }
             $busEntryPresent =$this->listingRepository->checkBusentry($busId,$new_date);
                      
             if($busEntryPresent==true){
                $records[] = $this->listingRepository->getBusData($busOperatorId,$busId);
             } 
         }

         $records = Arr::flatten($records);
         //return $records;
         $busCouponCode = [];
         $opCouponCode = [];
         foreach($records as $record){
             $busId = $record->id; 
             $busName = $record->name;
             $popularity = $record->popularity;
             $busNumber = $record->bus_number;
             $via = $record->via;
               
             if(isset($record->couponAssignedBus[0]->coupon)){                       //Bus wise coupon
                 $busCouponCode = $record->couponAssignedBus[0]->coupon->coupon_code;
             }
             if(isset($record->busOperator->coupon)){                                ///operator wise coupon
                 $couponCodeRecords = $record->busOperator->coupon;
                 $opCouponCode = $couponCodeRecords->pluck('coupon_code');
             }
             $CouponRecords = collect([$busCouponCode,$opCouponCode,$routeCouponCode]);
             $CouponRecords = $CouponRecords->flatten()->unique()->values()->all();
 
             ///Coupon applicable for specific date range
             $appliedCoupon = collect([]);
             $date = Carbon::now();
             $bookingDate = $date->toDateString();
             foreach($CouponRecords as $key => $coupon){
                 $type = $selCouponRecords->where('coupon_code',$coupon)->first()->valid_by;
                 switch($type){
                     case(1):    //Coupon available on journey date
                         $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                                                         ->where('from_date', '<=', $entry_date)
                                                         ->where('to_date', '>=', $entry_date)->all();           
                         break;
                     case(2):    //Coupon available on booking date
                         $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                                                         ->where('from_date', '<=', $bookingDate)
                                                         ->where('to_date', '>=', $bookingDate)->all();
                         break;      
                 }
                 if($dateInRange){
                     $appliedCoupon->push($coupon);
                  }
             }
 
             $maxSeatBook = $record->max_seat_book;
             $conductor_number ='';

             if($record->busContacts && isset($record->busContacts->phone)){
                $conductor_number = $record->busContacts->phone;
             }
             
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
 
             //$seatOpenDatas = $record->seatOpen;
             //$seatsOpenSeats = $seatOpenDatas->pluck('seatOpenSeats.id');
             //return $seatsOpenSeats;
 
             $totalSeats = $record->busSeats->where('ticket_price_id',$ticketPriceId)->count('id');
                                          
             $seatDatas = $record->busSeats->where('ticket_price_id',$ticketPriceId)->all();
             $amenityDatas = [];  
            if($record->busAmenities)
            {
                foreach($record->busAmenities as $a){
                    if($a->amenities != NULL)
                    {
                        if($a->amenities->amenities_image !=''){
                            $a->amenities->amenities_image = $path->amenity_url.$a->amenities->amenities_image;   
                  
                        }
                        $amenityDatas[] = $a;
                    }
<<<<<<< HEAD
                    if($a->amenities != null && isset($a->amenities->android_image) )
                    {
                        $a->amenities->android_image = $path->amenity_url.$a->amenities->android_image;   
                    }
                }
            }
             $safetyDatas = $record->busSafety;
             if($safetyDatas)
=======

                }
            }

             $safetyDatas = [];
             if($record->busSafety)
>>>>>>> eac68c74463d2c94f6622a47a3295c84bbb6a320
            {
                foreach($record->busSafety as $sd){
                    if($sd->safety != NULL)
                    {
                        if($sd->safety->safety_image !=''){
                            $sd->safety->safety_image = $path->safety_url.$sd->safety->safety_image; 
                  
                        }
                        $safetyDatas[] = $sd;
                         
                    }
                    if($sd->safety != null && isset($sd->safety->android_image) )
                    {
                        $sd->safety->android_image = $path->safety_url.$sd->safety->android_image;   
                    }
                }
            }
             $busPhotoDatas = [];
             if($record->busGallery)
             {
                 foreach($record->busGallery as  $bp){
                     if($bp->bus_image != null)
                     {
                        if($bp->bus_image!=''){
                            $bp->bus_image = $path->busphoto_url.$bp->bus_image; 
                        }
                         $busPhotoDatas[] = $bp;
                     }
                 }
             }
             
             $reviews=  $record->review;
 
             $Totalrating=0;
             $Totalrating_comfort=0;
             $Totalrating_clean=0;
             $Totalrating_behavior=0;
             $Totalrating_timing=0;
 
             if(count($record->review)>0){
                 foreach($record->review as $rv){
                   $Totalrating += $rv->rating_overall;                  
                   $Totalrating_comfort += $rv->rating_comfort;                  
                   $Totalrating_clean += $rv->rating_clean;                  
                   $Totalrating_behavior += $rv->rating_behavior;                  
                   $Totalrating_timing += $rv->rating_timing;           
                 } 
                 $Totalrating = number_format($Totalrating/count($record->review),1);
                 $Totalrating_comfort = number_format($Totalrating_comfort/count($record->review),1);
                 $Totalrating_clean = number_format($Totalrating_clean/count($record->review),1);
                 $Totalrating_behavior = number_format($Totalrating_behavior/count($record->review),1);
                 $Totalrating_timing = number_format($Totalrating_timing/count($record->review),1);    
             }
 
             $cancellationPolicyContent=$record->cancellation_policy_desc;
             $TravelPolicyContent=$record->travel_policy_desc;
           
             $cSlabDatas = $record->cancellationslabs->cancellationSlabInfo;
             $cSlabDuration = $cSlabDatas->pluck('duration');
             $cSlabDeduction = $cSlabDatas->pluck('deduction');
         
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
            $bookedSeats = $this->listingRepository->getBookedSeats($sourceID,$destinationID,$entry_date,$busId);
            $seatClassRecords = $seatClassRecords - $bookedSeats[1];
            $sleeperClassRecords = $sleeperClassRecords - $bookedSeats[0];
            $totalSeats = $totalSeats - $bookedSeats[2];
            $ListingRecords[] = array(
                 "busId" => $busId, 
                 "busName" => $busName,
                 "popularity" => $popularity,
                 "busNumber" => $busNumber,
                 "maxSeatBook" => $maxSeatBook,
                 "conductor_number" => $conductor_number,
                 "couponCode" =>$appliedCoupon->all(),
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
                 "amenity" =>$amenityDatas,
                 "safety" => $safetyDatas,
                 "busPhotos" => $busPhotoDatas,
                 "cancellationDuration" => $cSlabDuration,
                 "cancellationDuduction" => $cSlabDeduction,
                 "cancellationPolicyContent" => $cancellationPolicyContent,
                 "TravelPolicyContent" => $TravelPolicyContent,
                 "Totalrating" => $Totalrating,
                 "Totalrating_comfort" => $Totalrating_comfort,
                 "Totalrating_clean" => $Totalrating_clean,
                 "Totalrating_behavior" => $Totalrating_behavior,
                 "Totalrating_timing" => $Totalrating_timing,
                 "reviews" => $reviews
             );             
         }
         return $ListingRecords;

       // return $this->listingRepository->getAll($request);
    }

    public function getLocation(Request $request)
    {
        return $this->listingRepository->getLocation($request['locationName']);
    }

    public function filter(Request $request)
    {
        //return $this->listingRepository->filter($request);

        $booked = Config::get('constants.BOOKED_STATUS');   
        $price = $request['price'];
        $sourceID = $request['sourceID'];      
        $destinationID = $request['destinationID'];
        $busOperatorId = $request['bus_operator_id']; 
        $entry_date = $request['entry_date']; 
        $path= $this->commonRepository->getPathurls();
        $path= $path[0];  
        if($sourceID==null ||  $destinationID==null || $entry_date==null)
            return ""; 

        $entry_date = date("Y-m-d", strtotime($entry_date));    
        $busType = $request['busType'];
        $seatType = $request['seatType'];    
        $boardingPointId = $request['boardingPointId'];
        $dropingingPointId = $request['dropingingPointId'];
        $operatorId = $request['operatorId'];
        $amenityId = $request['amenityId'];
        
        $selCouponRecords = $this->listingRepository->getAllCoupon();

        $routeCoupon = $this->listingRepository->getrouteCoupon($sourceID,$destinationID);

             if(isset($routeCoupon[0]->coupon)){                           
                $routeCouponCode = $routeCoupon[0]->coupon->coupon_code;  //route wise coupon
             }else{
                 $routeCouponCode =[];
             }  

        $busDetails = $this->listingRepository->getticketPrice($sourceID,$destinationID,$busOperatorId);         

        $records = array();
        $FilterRecords = array();

        foreach($busDetails as $busDetail){
            $busId = $busDetail['bus_id'];
            $jdays = $busDetail['start_j_days'];

            if($jdays>1){
                $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
            }else{
                $new_date = $entry_date;
            }
                              
            $busEntryPresent =$this->listingRepository->checkBusentry($busId,$new_date);
                                  
            if($busEntryPresent==true){
               $records[] = $this->listingRepository->getFilterBusList($busOperatorId,$busId,$busType,
               $seatType,$boardingPointId,$dropingingPointId,$operatorId,$amenityId);
            }   
        }
        $records = Arr::flatten($records); 
        $busCouponCode = [];
        $opCouponCode = [];
        //return $records;
            foreach($records as $record){
                $busId = $record->id; 
                $busName = $record->name;
                $popularity = $record->popularity;
                $busNumber = $record->bus_number;
                $via = $record->via;

                if(isset($record->couponAssignedBus[0]->coupon)){                       //Bus wise coupon
                    $busCouponCode = $record->couponAssignedBus[0]->coupon->coupon_code;
                }
                if(isset($record->busOperator->coupon)){                                ///operator wise coupon
                    $couponCodeRecords = $record->busOperator->coupon;
                    $opCouponCode = $couponCodeRecords->pluck('coupon_code');
                }
                $CouponRecords = collect([$busCouponCode,$opCouponCode,$routeCouponCode]);
                $CouponRecords = $CouponRecords->flatten()->unique()->values()->all();
    
                ///Coupon applicable for specific date range
                $appliedCoupon = collect([]);
                $date = Carbon::now();
                $bookingDate = $date->toDateString();
                foreach($CouponRecords as $key => $coupon){
                    $type = $selCouponRecords->where('coupon_code',$coupon)->first()->valid_by;
                    switch($type){
                        case(1):    //Coupon available on journey date
                            $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                                        ->where('from_date', '<=', $entry_date)
                                        ->where('to_date', '>=', $entry_date)->all();           
                            break;
                        case(2):    //Coupon available on booking date
                            $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                            ->where('from_date', '<=', $bookingDate)
                            ->where('to_date', '>=', $bookingDate)->all();
                            break;      
                    }
                    if($dateInRange){
                        $appliedCoupon->push($coupon);
                     }
                }
                $maxSeatBook = $record->max_seat_book;
                $conductor_number ='';

                if($record->busContacts && isset($record->busContacts->phone)){
                   $conductor_number = $record->busContacts->phone;
                }
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
               
                if($amenityDatas)
            {
                foreach($amenityDatas as $a){
                    if($a->amenities != null || isset($a->amenities->amenities_image) )
                    {
                        $a->amenities->amenities_image = $path->amenity_url.$a->amenities->amenities_image;   
                    }
                    if($a->amenities != null || isset($a->amenities->android_image) )
                    {
                        $a->amenities->android_image = $path->amenity_url.$a->amenities->android_image;   
                    }   
                }
            }
                $safetyDatas = $record->busSafety;
                if($safetyDatas)
            {
                foreach($safetyDatas as $sd){
                    if($sd->safety != null && isset($sd->safety->safety_image) )
                    {
                        $sd->safety->safety_image = $path->safety_url.$sd->safety->safety_image;   
               
                
                $amenityDatas = [];  
                if($record->busAmenities)
                {
                    foreach($record->busAmenities as $a){
                        if($a->amenities != NULL)
                        {
                            if($a->amenities->amenities_image !=''){
                                $a->amenities->amenities_image = $path->amenity_url.$a->amenities->amenities_image;   
                      
                            }
                            $amenityDatas[] = $a;
                        }
    
                    }
                    if($sd->safety != null && isset($sd->safety->android_image) )
                    {
                        $sd->safety->android_image = $path->safety_url.$sd->safety->android_image;   
                    }
                }
    
                 $safetyDatas = [];
                 if($record->busSafety)
                {
                    foreach($record->busSafety as $sd){
                        if($sd->safety != NULL)
                        {
                            if($sd->safety->safety_image !=''){
                                $sd->safety->safety_image = $path->safety_url.$sd->safety->safety_image; 
                      
                            }
                            $safetyDatas[] = $sd;
                             
                        }
                    }
                }
                 $busPhotoDatas = [];
                 if($record->busGallery)
                 {
                     foreach($record->busGallery as  $bp){
                         if($bp->bus_image != null)
                         {
                            if($bp->bus_image!=''){
                                $bp->bus_image = $path->busphoto_url.$bp->bus_image; 
                            }
                             $busPhotoDatas[] = $bp;
                         }
                     }
                 }
                 
                $cancellationPolicyContent=$record->cancellation_policy_desc;
                $TravelPolicyContent=$record->travel_policy_desc;
                $reviews=  $record->review;

                $Totalrating=0;
                $Totalrating_comfort=0;
                $Totalrating_clean=0;
                $Totalrating_behavior=0;
                $Totalrating_timing=0;

                if(count($record->review)>0){
                    foreach($record->review as $rv){
                    $Totalrating += $rv->rating_overall;                  
                    $Totalrating_comfort += $rv->rating_comfort;                  
                    $Totalrating_clean += $rv->rating_clean;                  
                    $Totalrating_behavior += $rv->rating_behavior;                  
                    $Totalrating_timing += $rv->rating_timing;           
                    }
                    
                    $Totalrating = number_format($Totalrating/count($record->review),1);
                    $Totalrating_comfort = number_format($Totalrating_comfort/count($record->review),1);
                    $Totalrating_clean = number_format($Totalrating_clean/count($record->review),1);
                    $Totalrating_behavior = number_format($Totalrating_behavior/count($record->review),1);
                    $Totalrating_timing = number_format($Totalrating_timing/count($record->review),1);
                    
                }
              
                $cSlabDatas = $record->cancellationslabs->cancellationSlabInfo;
                $cSlabDuration = $cSlabDatas->pluck('duration');
                $cSlabDeduction = $cSlabDatas->pluck('deduction');
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
                $bookedSeats =$this->listingRepository->getBookedSeats($sourceID,$destinationID,$entry_date,$busId);
                $seatClassRecords = $seatClassRecords - $bookedSeats[1];
                $sleeperClassRecords = $sleeperClassRecords - $bookedSeats[0];
                $totalSeats = $totalSeats - $bookedSeats[2];

                $FilterRecords[] = array(
                    "busId" => $busId, 
                    "busName" => $busName,
                    "popularity" => $popularity,
                    "busNumber" => $busNumber, 
                    "maxSeatBook" => $maxSeatBook,
                    "conductor_number" => $conductor_number,
                    "couponCode" =>$appliedCoupon->all(),
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
                    "amenity" =>$amenityDatas,
                    "safety" => $safetyDatas,
                    "busPhotos" => $busPhotoDatas,
                    "cancellationDuration" => $cSlabDuration,
                    "cancellationDuduction" => $cSlabDeduction,
                    "cancellationPolicyContent" => $cancellationPolicyContent,
                    "TravelPolicyContent" => $TravelPolicyContent,
                    "Totalrating" => $Totalrating,
                    "Totalrating_comfort" => $Totalrating_comfort,
                    "Totalrating_clean" => $Totalrating_clean,
                    "Totalrating_behavior" => $Totalrating_behavior,
                    "Totalrating_timing" => $Totalrating_timing,
                    "reviews" => $reviews     
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

    public function getFilterOptions(Request $request)
    {

        $sourceID = $request['sourceID'];
        $destinationID = $request['destinationID']; 

        $busTypes =  $this->listingRepository->getbusTypes();
        $seatTypes = $this->listingRepository->getseatTypes();
        $boardingPoints = $this->listingRepository->getboardingPoints($sourceID);
        $dropingPoints = $this->listingRepository->getdropingPoints($destinationID);
        $busOperator = $this->listingRepository->getbusOperator();
        $amenities = $this->listingRepository->getamenities();

        $filterOptions[] = array(
           "busTypes" => $busTypes,
           "seatTypes" => $seatTypes,  
           "boardingPoints" => $boardingPoints,
           "dropingPoints"=> $dropingPoints,
           "busOperator"=>$busOperator,
           "amenities"=>$amenities   
        );
        return  $filterOptions;

        //return $this->listingRepository->getFilterOptions($request);
    }
    public function busDetails(Request $request)
    {
        return $this->listingRepository->busDetails($request);
    }
   
}