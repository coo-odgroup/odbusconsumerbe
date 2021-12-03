<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Repositories\PopularRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class PopularService
{
    protected $popularRepository;    
    public function __construct(PopularRepository $popularRepository)
    {
        $this->popularRepository = $popularRepository;
    }
    public function getPopularRoutes(Request $request)
    {
        $popularRoutes = array();

        $routenames = $this->popularRepository->getRoutes();

        foreach($routenames as $route){
           $srcId = $route->source_id;
           $destId = $route->destination_id;
           $count = $route->count;
           $srcName = $this->popularRepository->getRouteNames($srcId);
           $destName = $this->popularRepository->getRouteNames($destId);
            $popularRoutes[] = array(
                "sourceName" => $srcName, 
                "destinationName" => $destName,
                "count" => $count
            );
        } 
        return $popularRoutes;

    }
    public function getTopOperators(Request $request)
    {
      
        $busIds = $this->popularRepository->getBusIds();

           if($busIds->isEmpty()){
               return [];
           }
           else{
               foreach($busIds as $busId){
                   $bus_id = $busId->bus_id;
                   $count = $busId->count;
                    $opDetail = $this->popularRepository->getOperator($bus_id);
                    $opDetail=$opDetail[0];
                   $topOperators[] = array(
                       "id" => $opDetail->busOperator->id, 
                       "operatorName" => $opDetail->busOperator->operator_name, 
                       "operator_url" => $opDetail->busOperator->operator_url, 
                       "count" => $count
                       );
               } 
           }

           $temp = array_unique(array_column($topOperators, 'operatorName'));
           return $unique_arr = array_intersect_key($topOperators, $temp);


    }
    public function allRoutes(Request $request)
    {
        $allRoutes = array();
       
        $routenames = $this->popularRepository->getAllRoutes();

        foreach($routenames as $route){
           $srcId = $route->source_id;
           $destId = $route->destination_id;
           $count = $route->count;
           $srcName = $this->popularRepository->getRouteNames($srcId);
           $destName = $this->popularRepository->getRouteNames($destId);
            $allRoutes[] = array(
                "sourceName" => $srcName, 
                "destinationName" => $destName
            );
        } 
        return $allRoutes;

    }
    public function allOperators(Request $request)
    {
        return $this->popularRepository->allOperators($request);
    }
    public function operatorDetails(Request $request)
    {
       // return $this->popularRepository->operatorDetails($request);

       $allRoutes = array();
       $allAmenity=array();
       $allreviews=array();    
       $Totalrating=0;
          
      
        $operator_url = $request['operator_url'];
        $this->entry_date = date("Y-m-d", strtotime($request['entry_date']));

        $operatorDetails = $this->popularRepository->GetOperatorDetail($operator_url);
      
      if($operatorDetails){
      
          $buses = $operatorDetails[0]->bus;
          $busIds =$buses->pluck('id');
      
        if(!sizeof($busIds)){
            $opNameDetails['id'] = $operatorDetails[0]->id;
            $opNameDetails['operator_name'] = $operatorDetails[0]->operator_name;
            $opNameDetails['operator_info'] = $operatorDetails[0]->operator_info; 
            $opNameDetails['buses'] = [];
            $opNameDetails['routes'] = [];
            $opNameDetails['total_rating'] = $Totalrating;
            $opNameDetails['amenities'] = $allAmenity;
            $opNameDetails['reviews'] = $allreviews;
            $opNameDetails['popularRoutes'] = [];

            return $opNameDetails;
        }else {

         $allAmenity=  $this->popularRepository->GetAllBusAmenities($busIds);
         $allreviews=  $this->popularRepository->GetOperatorReviews($busIds);
         $Totalrating=  $this->popularRepository->Totalrating($busIds);

       

        //>>Find the popular routes of that Operator   
        $bookingRoutes = $this->popularRepository->GetRouteBookings($busIds);  

        if(sizeof($bookingRoutes)) {
            foreach($bookingRoutes as $bookingRoute){
                $srcName = $this->popularRepository->getRouteNames($bookingRoute['source_id']);
                $destName = $this->popularRepository->getRouteNames($bookingRoute['destination_id']);
                $depTime = $this->popularRepository->GetDepartureTime($bookingRoute['source_id'],$bookingRoute['destination_id'],$busIds);       
                
                $popularRoutes[] = [
                        "sourceName" => $srcName, 
                        "destinationName" => $destName,
                        "depTime" => date("H:i",strtotime($depTime)),
                        ];

            }  
        }else{
            $popularRoutes = [];
        } 

        //>>Find all the routes of that Operator
        $items = collect($operatorDetails)[0]->ticketPrice; 
        if(sizeof($items)){
            foreach($items as $item){
                $srcName = $this->popularRepository->getRouteNames($item['source_id']);
                $destName = $this->popularRepository->getRouteNames($item['destination_id']);
              
               $depTime = $this->popularRepository->GetDepartureTime($item['source_id'],$item['destination_id'],$busIds);       
             
                $allRoutes[] = [   
                    "sourceName" => $srcName, 
                    "destinationName" => $destName,
                    "depTime" => date("H:i",strtotime($depTime))
                ];       
            }
           
        }     

        $opNameDetails['id'] = $operatorDetails[0]->id;
        $opNameDetails['operator_name'] = $operatorDetails[0]->operator_name;
        $opNameDetails['operator_info'] = $operatorDetails[0]->operator_info;
        $opNameDetails['buses'] = $buses;
        $opNameDetails['amenities'] = $allAmenity;
        $opNameDetails['reviews'] = $allreviews;        
        $opNameDetails['total_rating'] = $Totalrating;
        $opNameDetails['routes'] = $allRoutes;
        $opNameDetails['popularRoutes'] = $popularRoutes;

        return $opNameDetails; 
     }  
        
    }else{
    return 'operator-not-found';
    }

}
}