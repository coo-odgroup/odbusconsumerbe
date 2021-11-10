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
use App\Models\Review;
use DB;
use Carbon\Carbon;

class PopularRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
   protected $review;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Booking $booking,Location $location,Review $review)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->booking = $booking;
        $this->location = $location;
        $this->review = $review;
    } 
    
    public function getRoutes(){
       return  $this->booking
        ->select('source_id','destination_id',(DB::raw('count(*) as count')))
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->groupBy('source_id', 'destination_id')
        ->orderBy('count', 'DESC')
        ->limit(10)
        ->get();
    }
 
    public function getRouteNames($sourceId){ 
        $sourceName = $this->location->where('id',$sourceId)->first()->name;
        return $sourceName;
    }

    public function getBusIds(){
        return  $this->booking
        ->select('bus_id',(DB::raw('count(*) as count')))
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->groupBy('bus_id')
        ->orderBy('count', 'DESC')
        ->get();
    }

    public function getOperatorName($operatorId){ 
        $records = $this->bus
        ->with('busOperator')
        ->where('id',$operatorId)->get();
        $opDetail = $records[0];
        return $opDetail;
    }

    public function getAllRoutes(){ 

        return $this->ticketPrice
        ->select('source_id','destination_id',(DB::raw('count(*) as count')))
        ->groupBy('source_id', 'destination_id')
        ->orderBy('count', 'DESC')
        ->get();
       
    }

    public function allOperators($request){  

        $operators = BusOperator::get(['id','operator_name','operator_url','operator_info']);
        return $operators;

    }

    public function GetOperatorDetail($operator_url){
        return BusOperator::where('operator_url', $operator_url)->with(['bus' => function ($q){ 
            $q->select('bus_operator_id','id','name');
            $q->with(['busAmenities' => function ($query) {
                 $query->select('bus_id','amenities_id');
                     $query->with(['amenities' =>  function ($a){
                         $a->select('id','name','icon');
                     }]);
                 }]);         
             }])   
            ->with('ticketPrice:bus_operator_id,source_id,destination_id') 
            ->get();
    }

    public function GetOperatorReviews($bus_id){
        return $this->review->where('bus_id',$bus_id)
        ->where('status',1)
        ->with(['users' =>  function ($u){
         $u->select('id','name','district','profile_image');
        }])->get();
    }

    public function GetRouteBookings($busIds){
        return Booking::whereIn('bus_id', $busIds)
        ->select('source_id','destination_id',(DB::raw('count(*) as count')))
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->groupBy('source_id','destination_id')
        ->orderBy('count', 'DESC')
        ->get();      
    }

    public function GetDepartureTime($source_id,$destination_id,$busIds){
        return TicketPrice::where('source_id',$source_id) 
        ->where('destination_id',$destination_id)
        ->whereIn('bus_id', $busIds) 
        ->orderBy('dep_time', 'ASC')  
        ->first()->dep_time;
    }


}