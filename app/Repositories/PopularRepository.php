<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\TicketPrice;
use App\Models\Booking;
use App\Models\Location;
use App\Models\BusOperator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use DB;
use Carbon\Carbon;

class PopularRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Booking $booking,Location $location)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->booking = $booking;
        $this->location = $location;
    }   
    
    public function getPopularRoutes($request)
    { 
        $popularRoutes = array();
        $routenames = $this->booking
        ->select('source_id','destination_id',(DB::raw('count(*) as count')))
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->groupBy('source_id', 'destination_id')
        ->orderBy('count', 'DESC')
        ->limit(10)
        ->get();
        foreach($routenames as $route){
           $srcId = $route->source_id;
           $destId = $route->destination_id;
           $count = $route->count;
           $srcName = $this->getRouteNames($srcId);
           $destName = $this->getRouteNames($destId);
            $popularRoutes[] = array(
                "sourceName" => $srcName, 
                "destinationName" => $destName,
                "count" => $count
            );
        } 
        return $popularRoutes;
    }
    public function getRouteNames($sourceId){ 
        $sourceName = $this->location->where('id',$sourceId)->first()->name;
        return $sourceName;
    }

    public function getTopOperators($request)
    {  
        $busIds = $this->booking
        ->select('bus_id',(DB::raw('count(*) as count')))
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->groupBy('bus_id')
        ->orderBy('count', 'DESC')
        ->get();
            if($busIds->isEmpty()){
                return "No booking exist to filter top operator";
            }
            else{
                foreach($busIds as $busId){
                    $opId = $busId->bus_id;
                    $count = $busId->count;
                    $opDetail = $this->getOperatorName($opId);
                    $topOperators[] = array(
                        "id" => $opDetail->busOperator->id, 
                        "operatorName" => $opDetail->busOperator->operator_name, 
                        "count" => $count
                        );
                } 
            }
            return $topOperators;
    }
    public function getOperatorName($operatorId){ 
        $records = $this->bus
        ->with('busOperator')
        ->where('id',$operatorId)->get();
        $opDetail = $records[0];
        return $opDetail;
    }

    public function allRoutes($request){ 
        $allRoutes = array();
       
        $routenames = $this->ticketPrice
        ->select('source_id','destination_id',(DB::raw('count(*) as count')))
        ->groupBy('source_id', 'destination_id')
        ->orderBy('count', 'DESC')
        ->get();
        foreach($routenames as $route){
           $srcId = $route->source_id;
           $destId = $route->destination_id;
           $count = $route->count;
           $srcName = $this->getRouteNames($srcId);
           $destName = $this->getRouteNames($destId);
            $allRoutes[] = array(
                "sourceName" => $srcName, 
                "destinationName" => $destName
            );
        } 
        return $allRoutes;
    }

    public function allOperators($request){  

        $operators = BusOperator::get(['id','operator_name','operator_info']);
        return $operators;

    }

    public function operatorDetails($request){ 
      
       $allRoutes = array();
       $allAmenity=array();
       $allreviews=array();    
       $Totalrating=0;
          
      
        $operatorId = $request['operator_id'];
        $this->entry_date = date("Y-m-d", strtotime($request['entry_date']));
        $operatorDetails = BusOperator::where('id', $operatorId)->with(['bus' => function ($q){ 
           $q->select('bus_operator_id','id','name');
           $q->with(['busAmenities' => function ($query) {
                $query->select('bus_id','amenities_id');
                    $query->with(['amenities' =>  function ($a){
                        $a->select('id','name','icon');
                    }]);
                }]);
                $q->with(['review' => function ($query) {
                    $query->select('bus_id','users_id','title','rating_overall','comments');
                    $query->with(['users' =>  function ($u){
                        $u->select('id','name','district','profile_image');
                    }]);
                    }]);
            }])   
           ->with('ticketPrice:bus_operator_id,source_id,destination_id') 
           ->get();
      
      //return $operatorDetails;
    
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
        }
      
     
      
      
        foreach($buses as $bus){  
          if($bus->busAmenities){
            foreach($bus->busAmenities as $bus_amenity){
              $allAmenity[] = $bus_amenity;
            }
          }
          
      
          
          if(count($bus->review)>0){
            foreach($bus->review as $rv){
              $Totalrating += $rv->rating_overall;
              $allreviews[] = $rv;
            }
            
            $Totalrating = $Totalrating/count($bus->review);
            
          }
	
        }
      
     
      
        //>>Find the popular routes of that Operator   
        $bookingRoutes = Booking::whereIn('bus_id', $busIds)
            ->select('source_id','destination_id',(DB::raw('count(*) as count')))
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->groupBy('source_id','destination_id')
            ->orderBy('count', 'DESC')
            ->get();        
        if(sizeof($bookingRoutes)) {
            foreach($bookingRoutes as $bookingRoute){
                $srcName = $this->getRouteNames($bookingRoute['source_id']);
                $destName = $this->getRouteNames($bookingRoute['destination_id']);
                $depTime = TicketPrice::where('source_id',$bookingRoute['source_id']) 
                            ->where('destination_id',$bookingRoute['destination_id'])
                            ->whereIn('bus_id', $busIds) 
                            ->orderBy('dep_time', 'ASC')  
                            ->first()->dep_time;       
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
                $srcName = $this->getRouteNames($item['source_id']);
                $destName = $this->getRouteNames($item['destination_id']);
                $allRoutes[] = [   
                    "sourceName" => $srcName, 
                    "destinationName" => $destName
                ];       
            }
            
            //unset($allRoutes);
        }
        // else{
        //     $opNameDetails['buses'] = $buses;
        //     $opNameDetails['routes'] = [];
        //     $opNameDetails['popularRoutes'] = $popularRoutes;
        //     $opNameDetails = ['buses' => $buses,'routes' => [],'popularRoutes' => $popularRoutes];
        // }

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




    public function allOperatorDetails($request){ 
       
         $operatorDetails = BusOperator:: with(['bus' => function ($q){ 
            $q->select('bus_operator_id','id','name');
            $q->with(['busAmenities' => function ($query) {
                $query->select('bus_id','amenities_id');
                 $query->with(['amenities' =>  function ($a){
                    $a->select('id','name','icon');
                        }]);
                    }]);
                 }])
            ->with('ticketPrice:bus_operator_id,source_id,destination_id') 
            ->select(['id','operator_name']) 
            ->get();
       
        foreach($operatorDetails as $operatorDetail){
            $items = collect($operatorDetail)['ticket_price']; 
         
           if(!empty($items)){
                $buses = collect($operatorDetail)['bus'];
               
                $opName =  $operatorDetail['operator_name'];
                //$operatorRecords[] = ["operator_name"=>$opName]; 
                foreach($items as $item){
                    
                    $srcName = $this->getRouteNames($item['source_id']);
                    $destName = $this->getRouteNames($item['destination_id']);
                    $routeRecords[] = [
                        "sourceName" => $srcName, 
                        "destinationName" => $destName
                    ];       
                }
                // $opNameDetails[] = [$opName=>$buses, 
                $opNameDetails[] = [$opName => [$buses,$routeRecords]];
                unset($routeRecords);

                // $popularRoutes = array();
                //     $routenames = $this->booking
                //     ->where('source_id', $srcName)
                //     ->where('destination_id', $destName)
                //     ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                //     ->groupBy('source_id', 'destination_id')
                //     ->orderBy('count', 'DESC')
                //     ->limit(10)
                //     ->get();
            }   
         
        } 
        
 
        return $opNameDetails;
        
    }


}