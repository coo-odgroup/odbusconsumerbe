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
use App\Models\Booking;
use App\Models\BusSchedule;
use App\Models\CouponRoute;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Repositories\CommonRepository;

use DateTime;
use Time;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Config;

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
    protected $booking;
    
    public function __construct(Bus $bus,Location $location,BusOperator $busOperator,BusStoppageTiming $busStoppageTiming,BusType $busType,Amenities $amenities,BoardingDroping $boardingDroping,BusClass $busClass,SeatClass $seatClass,BusSeats $busSeats,TicketPrice $ticketPrice,BusScheduleDate $busScheduleDate,BusSchedule $busSchedule, Booking $booking,CommonRepository $commonRepository)
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
        $this->booking=$booking;
        $this->commonRepository = $commonRepository;
     }   

     public function getLocation($searchValue)
     {        
         return $this->location
         ->where('name', 'like', '%' .$searchValue . '%')
         ->where('status','1')  
         ->orWhere('synonym', 'like', '%' .$searchValue . '%')
         ->orderBy('name','ASC')
         ->where('status','1')  
         ->get(['id','name','synonym']);
     }


     public function getLocationID($name)
     {
         return $this->location->where("name", $name)->where("status", 1)->get('id');
     }

     public function getrouteCoupon($sourceID,$destinationID)
     {
         return CouponRoute::where('source_id', $sourceID)
         ->where('destination_id', $destinationID)
         ->with('coupon')
         ->get();
     }

     public function getAllCoupon()
     {
         return Coupon::where('status','1')->get();
     }


     public function getticketPrice($sourceID,$destinationID,$busOperatorId,$journey_date)
     {
        $CurrentDate = Carbon::now()->toDateString();
        $CurrentTime = Carbon::now()->toTimeString();
        $seizedTime = $this->ticketPrice
                            ->where('source_id', $sourceID)
                            ->where('destination_id', $destinationID)
                            ->where('status',1)
                            ->first()->seize_booking_minute;
        $seizedTime = intdiv($seizedTime, 60).':'. ($seizedTime % 60).':'.'00';
        $secs = strtotime($seizedTime) - strtotime("00:00:00");
        $FinalSeizedTime = date("H:i:s", strtotime($CurrentTime) + $secs);   
                          
        return $this->ticketPrice
        ->where('source_id', $sourceID)
        ->where('destination_id', $destinationID)
        ->where('status',1)
        ->when($journey_date == $CurrentDate, function ($query) use ($FinalSeizedTime){
            $query->whereTime('dep_time','>',$FinalSeizedTime);
            })
        ->when($busOperatorId != null || isset($busOperatorId), function ($query) use ($busOperatorId){
            $query->where('bus_operator_id',$busOperatorId);
            })
        ->orderBy('dep_time', 'asc')
        ->get(['bus_id','start_j_days']);  
     }

     public function checkBusentry($busId,$new_date)
     {
       return $this->busSchedule->where('bus_id', $busId)->where('status',1)
                                 ->with(['busScheduleDate' => function ($bsd) use ($new_date){
                                     $bsd->where('entry_date',$new_date);
                                     $bsd->where('status',1);
                                 }])->exists();
     }

     public function getBusScheduleID($busId)
     {
       return $this->busSchedule->whereIn('bus_id', (array)$busId)->pluck('id'); 
     }

     public function getBusList($source,$destination,$busOperatorId,$entry_date)
     {
            return $this->bus
                        //->where('bus_operator_id', $busOperatorId) 
                        ->when($busOperatorId != null || isset($busOperatorId), function ($query) use ($busOperatorId){
                            $query->where('bus_operator_id',$busOperatorId);
                            })
                        ->with(['ticketPrice' => function ($tp) use($source,$destination,$busOperatorId) {
                                 $tp->where('source_id', $source);
                                 $tp->where('destination_id', $destination);
                                 $tp->where('bus_operator_id', $busOperatorId);
                              }])
                        ->with(['busSchedule' => function ($bs) use($entry_date) {
                        $bs->with(['busScheduleDate' => function ($bsd) use($entry_date){
                        $bsd->where('entry_date',$entry_date);
                        }]);
                        }])
                        ->with('couponAssignedBus.coupon')
                        ->with('busOperator.coupon')
                        ->with('busContacts')       
                        ->with('busAmenities.amenities')     
                        ->with('busSafety.safety')
                        ->with('BusType.busClass')
                        ->with('busSeats.seats')
                        //->with('seatOpen.seatOpenSeats')
                        ->with('BusSitting')
                        ->with('busGallery')
                        ->with('cancellationslabs.cancellationSlabInfo')
                        ->with(['review' => function ($query) {                    
                        $query->where('status',1);
                        $query->select('bus_id','users_id','title','rating_overall','rating_comfort','rating_clean','rating_behavior','rating_timing','comments');  
                        $query->with(['users' =>  function ($u){
                            $u->select('id','name','profile_image');
                        }]);                      
                        }])
                        ->where('status','1')
                        ->get();
        
     }

     public function getBusData($busOperatorId,$busId)
     {
        return $this->bus
        //->where('bus_operator_id', $busOperatorId) 
        ->when($busOperatorId != null || isset($busOperatorId), function ($query) use ($busOperatorId){
            $query->where('bus_operator_id',$busOperatorId);
            })
        ->with('couponAssignedBus.coupon')
        ->with('busOperator.coupon')
        ->with('busContacts')       
        //->with('busAmenities.amenities')
        ->with(['busAmenities'  => function ($query) {
            $query->with(['amenities' =>function ($a){
                $a->where('status',1);
                $a->select('id','name','amenities_image','android_image');
            }]);
        }]) 
        //->with('busSafety.safety')
        ->with(['busSafety'  => function ($query) {
            $query->with(['safety' =>function ($a){
                $a->where('status',1);
                $a->select('id','name','safety_image','android_image');
            }]);
        }]) 
        ->with('BusType.busClass')
        ->with('busSeats.seats')
        //->with('seatOpen.seatOpenSeats')
        ->with('BusSitting')
        ->with(['busGallery' => function ($a){
            $a->where('status',1);
            $a->select('id','bus_id','alt_tag','bus_image');
            }])
        ->with('cancellationslabs.cancellationSlabInfo')
        ->with(['review' => function ($query) {                    
            $query->where('status',1);
            $query->select('bus_id','users_id','title','rating_overall','rating_comfort','rating_clean','rating_behavior','rating_timing','comments');  
            $query->with(['users' => function ($u){
                $u->select('id','name','profile_image');
            }]);                      
            }])
        ->where('status','1')
        ->where('id',$busId)
        ->get();
     }

     public function getFilterBusList($busOperatorId,$busId,$busType,
     $seatType,$boardingPointId,$dropingingPointId,$operatorId,$amenityId){
         return  $this->bus
         ->when($busOperatorId != null || isset($busOperatorId), function ($query) use ($busOperatorId){
            $query->where('bus_operator_id',$busOperatorId);
            })
         ->with('couponAssignedBus.coupon')
         ->with('busOperator.coupon')
         //->with('busOperator')
         //->with('busAmenities.amenities')
         //->with('busSafety.safety')
         ->with(['busAmenities'  => function ($query) {
            $query->with(['amenities' =>function ($a){
                $a->where('status',1);
                $a->select('id','name','amenities_image','android_image');
            }]);
        }]) 
        ->with(['busSafety'  => function ($query) {
            $query->with(['safety' =>function ($a){
                $a->where('status',1);
                $a->select('id','name','safety_image','android_image');
            }]);
        }]) 
         ->with('BusType.busClass')
         ->with('busSeats.seats')
         ->with('BusSitting')
         //->with('busGallery')
         ->with(['busGallery' => function ($a){
            $a->where('status',1);
            $a->select('id','bus_id','alt_tag','bus_image');
            }])
         ->with('cancellationslabs.cancellationSlabInfo')
         ->with(['review' => function ($query) {                    
             $query->where('status',1);
             $query->select('bus_id','users_id','title','rating_overall','rating_comfort','rating_clean','rating_behavior','rating_timing','comments');  
             $query->with(['users' =>  function ($u){
                 $u->select('id','name','profile_image');
             }]);                      
             }])
         ->where('status','1')
         ->where('id',$busId)
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
         ->where('status','1')
         ->get();
     }
    
 
    public function getAll_old($request)
    { 
       
        $source = $request['source'];
        $destination = $request['destination'];
        $entry_date = $request['entry_date'];
        $busOperatorId = $request['bus_operator_id'];
        $entry_date = date("Y-m-d", strtotime($entry_date));
        
        $sourceID =  $this->location->where("name", $source)->get('id');
        $destinationID =  $this->location->where("name", $destination)->get('id');

        if($sourceID->count()==0 || $destinationID->count()==0)
           return "";
        $sourceID =  $this->location->where("name", $source)->first()->id;
        $destinationID =  $this->location->where("name", $destination)->first()->id;  

        $selCouponRecords = Coupon::where('status','1')->get();
        $routeCoupon = CouponRoute::where('source_id', $sourceID)
                                    ->where('destination_id', $destinationID)
                                    ->with('coupon')
                                    ->get();

        if(isset($routeCoupon[0]->coupon)){                           
           $routeCouponCode = $routeCoupon[0]->coupon->coupon_code;//route wise coupon
        }else{
           $routeCouponCode =[];
        }  
        $busDetails = $this->ticketPrice
                ->where('source_id', $sourceID)
                ->where('destination_id', $destinationID)
                ->where('bus_operator_id', $busOperatorId)
                ->get(['bus_id','start_j_days']);  
    
        $records = array();
        $ListingRecords = array();
        foreach($busDetails as $busDetail){
            $busId = $busDetail['bus_id'];
            $jdays = $busDetail['start_j_days'];
            $busEntryPresent =$this->busSchedule->where('bus_id', $busId)->exists();
                                 
            if($busEntryPresent==true){
                $busScheduleId = $this->busSchedule->whereIn('bus_id', (array)$busId)->pluck('id');    
                $dates = $this->busScheduleDate
                              ->where('bus_schedule_id', $busScheduleId)           
                              ->pluck('entry_date')->toarray();
                if($jdays>1){
                    $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
                }else{
                    $new_date = $entry_date;
                }
                if(in_array($new_date, $dates))
                {
                    $records[] = $this->bus
                    ->where('bus_operator_id', $busOperatorId) 
                    ->with('couponAssignedBus.coupon')
                    ->with('busOperator.coupon')
                    ->with('busContacts')
                    //->with('busOperator')       
                    ->with('busAmenities.amenities')
                    ->with('busSafety.safety')
                    ->with('BusType.busClass')
                    ->with('busSeats.seats')
                    //->with('seatOpen.seatOpenSeats')
                    ->with('BusSitting')
                    ->with('busGallery')
                    ->with('cancellationslabs.cancellationSlabInfo')
                    ->with(['review' => function ($query) {                    
                        $query->where('status',1);
                        $query->select('bus_id','users_id','title','rating_overall','rating_comfort','rating_clean','rating_behavior','rating_timing','comments');  
                        $query->with(['users' =>  function ($u){
                            $u->select('id','name','profile_image');
                        }]);                      
                        }])
                    ->where('status','1')
                    ->where('id',$busId)
                    ->get();
                } 
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

            //$seatOpenDatas = $record->seatOpen;
            //$seatsOpenSeats = $seatOpenDatas->pluck('seatOpenSeats.id');
            //return $seatsOpenSeats;

            $totalSeats = $record->busSeats->where('ticket_price_id',$ticketPriceId)->count('id');
                                                     
            $seatDatas = $record->busSeats->where('ticket_price_id',$ticketPriceId)->all();
            $amenityDatas = $record->busAmenities;
            $amenityName = $amenityDatas->pluck('amenities.name');
            $amenityIcon = $amenityDatas->pluck('amenities.icon');
            $safetyDatas = $record->busSafety;
            $safetyName = $safetyDatas->pluck('safety.name');
            $safetyIcon = $safetyDatas->pluck('safety.icon');
            $busPhotoDatas = $record->busGallery;

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
              
            $busPhotos = (!empty($busPhotoDatas)) ? $busPhotoDatas->pluck('image') : [];
          
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
           $bookedSeats = $this->getBookedSeats($sourceID,$destinationID,$entry_date,$busId);

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
                "amenityName" =>$amenityName,
                "amenityIcon" => $amenityIcon,
                "safetyIconName" =>$safetyName,
                "safetyIcon" => $safetyIcon,
                "busPhotos" => $busPhotos,
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
    }

 //Calculate Booked seats and remove it from total count
    public function getBookedSeats($sourceID,$destinationID,$entry_date,$busId){
        $booked = Config::get('constants.BOOKED_STATUS');
        $seatHold = Config::get('constants.SEAT_HOLD_STATUS');

        $booked_seats = $this->booking->where('journey_dt',$entry_date)
                                      ->where('bus_id',$busId)
                                       ->where('source_id',$sourceID)
                                       ->where('destination_id',$destinationID)
                                       ->whereIn('status',[$booked,$seatHold])
                                      //->where('status',$booked)
                                       ->with(["bookingDetail.busSeats.seats"]) 
                                       ->get();
       
        $collection = collect($booked_seats);
        $i = 0;
        $seaterRecords = 0;
        $sleeperRecords = 0;
        foreach($collection as $cid){
        foreach($cid->bookingDetail as $cbd)
        {
            $class = $cbd->busSeats->seats->seat_class_id;
            if($class==1){
                $seaterRecords ++;
            }
            elseif($class==2 || $class==3){
                $sleeperRecords ++;
            }
        }
        $i++;
        } 
        $totalBookedCount= $sleeperRecords+$seaterRecords;
        return [$sleeperRecords,$seaterRecords,$totalBookedCount];

    }   
    public function getbusTypes()
    { 
        return $this->busClass->get(['id','class_name']);
    }

    public function getseatTypes()
    {
        return $this->seatClass->where('id',1)->orWhere('id',2)->get(['id','name']);
    }

    public function getboardingPoints($sourceID)
    {
        return $this->boardingDroping->where('location_id', $sourceID)
                                     ->where('status', '1')
                                     ->get(['id','boarding_point']);
    }

    public function getdropingPoints($destinationID)
    {
        return $this->boardingDroping->where('location_id', $destinationID)
                                     ->where('status', '1')
                                     ->get(['id','boarding_point']);       
    }

    public function getbusOperator()
    {
        return $this->busOperator->where('status', '1')->get(['id','operator_name']);
    }

    public function getamenities()
    {
        $path= $this->commonRepository->getPathurls();
        $path= $path[0];

        $amenityDatas = $this->amenities->where('status', '1')->get(['id','name','amenities_image','android_image']);
        foreach($amenityDatas as $a){
            if($a != null && isset($a->amenities_image) )
            {
                $a->amenities_image = $path->amenity_url.$a->amenities_image;   
            }
            if($a != null && isset($a->android_image) )
            {
                $a->android_image = $path->amenity_url.$a->android_image;   
            }
        }
       return $amenityDatas;

    }

    public function filter_old($request)
    {   
        $booked = Config::get('constants.BOOKED_STATUS');   
        $price = $request['price'];
        $sourceID = $request['sourceID'];      
        $destinationID = $request['destinationID'];
        $busOperatorId = $request['bus_operator_id']; 
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
        
        $selCouponRecords = Coupon::where('status','1')->get();
        $routeCoupon = CouponRoute::where('source_id', $sourceID)
                                    ->where('destination_id', $destinationID)
                                    ->with('coupon')
                                    ->get();

             if(isset($routeCoupon[0]->coupon)){                           
                $routeCouponCode = $routeCoupon[0]->coupon->coupon_code;  //route wise coupon
             }else{
                 $routeCouponCode =[];
             }  

        $busDetails = $this->ticketPrice
                            ->where('source_id', $sourceID)
                            ->where('destination_id', $destinationID)
                            ->where('bus_operator_id', $busOperatorId)
                            ->get(['bus_id','start_j_days']);

        $records = array();
        $FilterRecords = array();

        foreach($busDetails as $busDetail){
            $busId = $busDetail['bus_id'];
            $jdays = $busDetail['start_j_days'];
            $busEntryPresent =$this->busSchedule->where('bus_id', $busId) ->exists(); 
                               
            if($busEntryPresent==true){
                $busScheduleDate = $this->busSchedule->whereIn('bus_id', (array)$busId)->pluck('id');
                $dates = $this->busScheduleDate->where('bus_schedule_id', $busScheduleDate)->pluck('entry_date')->toarray();
                                    
                if($jdays>1){
                    $new_date = date('Y-m-d', strtotime('-1 day', strtotime($entry_date)));
                }else{
                    $new_date = $entry_date;
                }
                if(in_array($new_date, $dates))
                {
                    $records[] = $this->bus
                    ->where('bus_operator_id', $busOperatorId)
                    ->with('couponAssignedBus.coupon')
                    ->with('busOperator.coupon')
                    ->with('busOperator')
                    ->with('busAmenities.amenities')
                    ->with('busSafety.safety')
                    ->with('BusType.busClass')
                    ->with('busSeats.seats')
                    ->with('BusSitting')
                    ->with('busGallery')
                    ->with('cancellationslabs.cancellationSlabInfo')
                    ->with(['review' => function ($query) {                    
                        $query->where('status',1);
                        $query->select('bus_id','users_id','title','rating_overall','rating_comfort','rating_clean','rating_behavior','rating_timing','comments');  
                        $query->with(['users' =>  function ($u){
                            $u->select('id','name','profile_image');
                        }]);                      
                        }])
                    ->where('status','1')
                    ->where('id',$busId)
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
              
                $busPhotos = (!empty($busPhotoDatas)) ? $busPhotoDatas->pluck('image') : [];

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
                $bookedSeats = $this->getBookedSeats($sourceID,$destinationID,$entry_date,$busId);
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
                    "amenityName" =>$amenityName,
                    "amenityIcon" => $amenityIcon, 
                    "safetyIconName" =>$safetyName,
                    "safetyIcon" => $safetyIcon,
                    "busPhotos" => $busPhotos,
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

    public function busDetails($request)
    { 
        $busId = $request['bus_id'];
        $sourceID = $request['source_id'];      
        $destinationID = $request['destination_id']; 

        $result['busDetails'] = $this->bus->where('id',$busId)->where('id',$busId)
                                ->with('cancellationslabs.cancellationSlabInfo')
                                ->with('busAmenities.amenities')
                                ->with('busSafety.safety')
                                ->with('busGallery')
                                ->get();        
        $result['boarding_point'] = $this->busStoppageTiming
                                              ->where('bus_id', $busId)
                                              ->where('location_id', $sourceID)
                                              ->get();
        $result['dropping_point'] = $this->busStoppageTiming
                                              ->where('bus_id', $busId)
                                              ->where('location_id', $destinationID)
                                              ->get();                                     

        return $result;
    }

}