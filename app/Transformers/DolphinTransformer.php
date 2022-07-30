<?php

namespace App\Transformers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use App\Services\DolphinService;
use App\Repositories\ListingRepository;


class DolphinTransformers
{

    protected $listingRepository; 
    protected $DolphinService;
   
    public function __construct(ListingRepository $listingRepository,DolphinService $DolphinService)
    {

        $this->listingRepository = $listingRepository;
        $this->DolphinService = $DolphinService;
        
    }
    
    public function BusList($request){

        $srcResult= $this->listingRepository->getLocationID($request['source']);
        $destResult= $this->listingRepository->getLocationID($request['destination']);

        $dolphinresult=[];

        if($srcResult[0]->is_dolphin==1 && $destResult[0]->is_dolphin==1){

            $dolphin_source=$srcResult[0]->dolphin_id;
            $dolphin_dest=$destResult[0]->dolphin_id;

            $data= $this->DolphinService->GetAvailableRoutes($dolphin_source,$dolphin_dest,$entry_date);

            $dolphinresult= $this->BusListProcess($data);

        }

        return $dolphinresult;


    }

    public function Filter($request){

        $sourceID = $request['sourceID'];      
        $destinationID = $request['destinationID'];

        $srcResult= $this->listingRepository->getLocationResult($sourceID);
        $destResult= $this->listingRepository->getLocationResult($destinationID);

        $dolphinresult=[];

        if($srcResult[0]->is_dolphin==1 && $destResult[0]->is_dolphin==1){

            $dolphin_source=$srcResult[0]->dolphin_id;
            $dolphin_dest=$destResult[0]->dolphin_id;
            $dolphinresult= $this->DolphinService->GetAvailableRoutes($dolphin_source,$data,$entry_date);

            $dolphinresult= $this->BusListProcess($data);

        } 

        return $dolphinresult;

    }

    public function BusListProcess($data){


        $dolphinresult=[];

        if (count($data) == count($data, COUNT_RECURSIVE)){

            // return $data;
            
            if(strpos('AM',$data['ArrivalTime']) == 0 && strpos('PM',$data['RouteTime']) ==0){
              $booking_date= date('Y-m-d',strtotime($data['BookingDate']));        
              $arrival_date= date('Y-m-d',strtotime($data['BookingDate']. ' +1 day'));         
     
            }else{
     
               $arrival_date=$booking_date= date('Y-m-d',strtotime($data['BookingDate']));  
     
             }
     
             $booking_date_time= $booking_date.' '.$data['RouteTime'];
             $arrival_date_time= $arrival_date.' '.$data['ArrivalTime'];
     
             
     
             $d1 = new DateTime($booking_date_time);
             $d2 = new DateTime($arrival_date_time);
             $interval = $d2->diff($d1);
     
             $duration= $interval->format('%hh %im');
     
     
     
             // $duration=  $arrival_date_time - $booking_date_time;
     
             $dolphinresult[]=[
                 "origin"=> "DOLPHIN",
                 "srcId"=> $data['FromCityId'],
                 "destId"=> $data['ToCityId'],
                 "display"=> "show",
                 "CompanyID"=> $data['CompanyID'],
                 "ReferenceNumber"=>$data['ReferenceNumber'],
                 "BoardingPoints"=>$data['BoardingPoints'],
                 "DroppingPoints"=>$data['DroppingPoints'],
                 "busId"=> $data['RouteID'],
                 "RouteTimeID"=> $data['RouteTimeID'],
                 "busName"=> $data['CompanyName'],
                 "via"=> "",
                 "popularity"=> null,
                 "busNumber"=> "",
                 "maxSeatBook"=> 6,
                 "conductor_number"=> "",
                 "couponCode"=> [],
                 "couponDetails"=> [],
                 "operatorId"=> '',
                 "operatorUrl"=> "",
                 "operatorName"=> $data['CompanyName'],
                 "sittingType"=> "",
                 "bus_description"=> "Luxury A/C Sleeper+Seater",
                 "busType"=> ($data['BusType'] == 0) ? 'AC' : 'NON AC', //1 - non ac
                 "busTypeName"=> $data['ArrangementName'],
                 "totalSeats"=> $data['EmptySeats'],
                 "seaters"=> '',
                 "sleepers"=> '',
                 "startingFromPrice"=> ($data['BusType'] == 0) ? $data['AcSeatRate'] : $data['NonAcSeatRate'] ,  // NonAcSeatRate,NonAcSleeperRate,AcSeatRate,AcSleeperRate
                 "departureTime"=> $data['CityTime'],
                 "arrivalTime"=> $data['ArrivalTime'],
                 "totalJourneyTime"=> $duration, 
                 "amenity"=> [],
                 "safety"=> [],
                 "busPhotos"=> [],
                 "cancellationDuration"=> [],
                 "cancellationDuduction"=> [],
                 "cancellationPolicyContent"=> null,
                 "TravelPolicyContent"=> null,
                 "Totalrating"=> 0,
                 "Totalrating_5star"=> 0,
                 "Totalrating_4star"=> 0,
                 "Totalrating_3star"=> 0,
                 "Totalrating_2star"=> 0,
                 "Totalrating_1star"=> 0,
                 "reviews"=> []
                ];
     
           } else{
     
             foreach($data as $v){
     
               if(strpos('AM',$v['ArrivalTime']) == 0 && strpos('PM',$v['RouteTime']) ==0){
                 $booking_date= date('Y-m-d',strtotime($v['BookingDate']));        
                 $arrival_date= date('Y-m-d',strtotime($v['BookingDate']. ' +1 day'));         
        
                }else{
        
                  $arrival_date=$booking_date= date('Y-m-d',strtotime($v['BookingDate']));  
        
                }
        
                $booking_date_time= $booking_date.' '.$v['RouteTime'];
                $arrival_date_time= $arrival_date.' '.$v['ArrivalTime'];
        
                
        
                $d1 = new DateTime($booking_date_time);
                $d2 = new DateTime($arrival_date_time);
                $interval = $d2->diff($d1);
        
                $duration= $interval->format('%hh %im');
               
               $dolphinresult[]=[
                 "origin"=> "DOLPHIN",
                 "srcId"=> $v['FromCityId'],
                 "destId"=> $v['ToCityId'],
                 "display"=> "show",
                 "CompanyID"=> $v['CompanyID'],
                 "ReferenceNumber"=>$v['ReferenceNumber'],
                 "BoardingPoints"=>$v['BoardingPoints'],
                 "DroppingPoints"=>$v['DroppingPoints'],
                 "busId"=> $v['RouteID'],
                 "RouteTimeID"=> $v['RouteTimeID'],
                 "busName"=> $v['CompanyName'],
                 "via"=> "",
                 "popularity"=> null,
                 "busNumber"=> "",
                 "maxSeatBook"=> 6,
                 "conductor_number"=> "",
                 "couponCode"=> [],
                 "couponDetails"=> [],
                 "operatorId"=> '',
                 "operatorUrl"=> "",
                 "operatorName"=> $v['CompanyName'],
                 "sittingType"=> "",
                 "bus_description"=> "Luxury A/C Sleeper+Seater",
                 "busType"=> ($v['BusType'] == 0) ? 'AC' : 'NON AC', //1 - non ac
                 "busTypeName"=> $v['ArrangementName'],
                 "totalSeats"=> $v['EmptySeats'],
                 "seaters"=> '',
                 "sleepers"=> '',
                 "startingFromPrice"=> ($v['BusType'] == 0) ? $v['AcSeatRate'] : $v['NonAcSeatRate'] ,  // NonAcSeatRate,NonAcSleeperRate,AcSeatRate,AcSleeperRate
                 "departureTime"=> $v['CityTime'],
                 "arrivalTime"=> $v['ArrivalTime'],
                 "totalJourneyTime"=> $duration, 
                 "amenity"=> [],
                 "safety"=> [],
                 "busPhotos"=> [],
                 "cancellationDuration"=> [],
                 "cancellationDuduction"=> [],
                 "cancellationPolicyContent"=> null,
                 "TravelPolicyContent"=> null,
                 "Totalrating"=> 0,
                 "Totalrating_5star"=> 0,
                 "Totalrating_4star"=> 0,
                 "Totalrating_3star"=> 0,
                 "Totalrating_2star"=> 0,
                 "Totalrating_1star"=> 0,
                 "reviews"=> []
                 
             ];        
     
             }
           }

           return $dolphinresult;

    }
   
}