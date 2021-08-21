<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\TicketPrice;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Support\Facades\Log;
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
        ->limit(5)
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
  
        foreach($busIds as $busId){
            $opId = $busId->bus_id;
            $count = $busId->count;
            $opName = $this->getOperatorName($opId);
            $topOperators[] = array(
                 "operatorName" => $opName, 
                 "count" => $count
             );
         } 
         return $topOperators;
    }
    public function getOperatorName($operatorId){ 
        $records = $this->bus
        ->with('busOperator')
        ->where('id',$operatorId)->get();
        foreach($records as $record){
            $operatorName = $record->busOperator->operator_name;
         } 
        return $operatorName;
    }

}