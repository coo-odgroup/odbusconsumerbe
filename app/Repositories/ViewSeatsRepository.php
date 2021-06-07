<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\TicketPrice;
use App\Models\BoardingDroping;
use App\Models\Location;
use App\Models\BusSeats;
use Illuminate\Support\Facades\Log;

class ViewSeatsRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $boardingDroping;
    protected $location;
    protected $busSeats;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,BoardingDroping $boardingDroping,Location $location,BusSeats $busSeats)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->boardingDroping = $boardingDroping;
        $this->location = $location;
        $this->busSeats = $busSeats;
    }   
    
    public function getAllViewSeats($request)
    { 
        $busId = $request['busId'];
        $viewSeats_arr =  $this->bus
        ->with('busSeatLayout.seats')
        ->where('id', $busId)
        //->groupBy('seatType')
        ->get();
        return $viewSeats_arr;
    }
    
    public function getPriceOnSeatsSelection($request)
    {
        $seaterIds = $request['seater'];
        $sleeperIds = $request['sleeper'];
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destinationId = $request['destinationId'];

        $busWithTicketPrice =  $this->bus->with('ticketPrice')
        ->whereHas('ticketPrice', function ($query) use ($busId,$sourceId, $destinationId){
            $query->where([
                ['bus_id', $busId],
                ['source_id', $sourceId],
                ['destination_id', $destinationId],   
            ]);            
            })      
        ->get();
      
        //Priyadarshi::Bus and Bustoppage relationships?????
        //Remove hard coding values.
       $totalPrice = count($seaterIds)*$busWithTicketPrice[0]->ticketPrice[0]->base_seat_fare+
       count($sleeperIds)*$busWithTicketPrice[0]->ticketPrice[0]->base_sleeper_fare;
       
       return  $totalPrice;
    }

    public function getBoardingDroppingPoints($request)
    { 
        $locationId = $request['locationId'];
        $boardingPoints =  $this->boardingDroping
        ->where('location_id', $locationId)
        ->get();
        return $boardingPoints;

    }

    public function getAllLocations()
    {
        return $this->location->orderBy('name','ASC')->get('name');
    }

}