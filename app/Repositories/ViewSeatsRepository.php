<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\TicketPrice;
use App\Models\BoardingDroping;
use App\Models\Location;
use App\Models\BusSeats;
use App\Models\Seats;
use Illuminate\Support\Facades\Log;
use DB;

class ViewSeatsRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $boardingDroping;
    protected $location;
    protected $busSeats;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,BoardingDroping $boardingDroping,Location $location,BusSeats $busSeats, Seats $seats)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->boardingDroping = $boardingDroping;
        $this->location = $location;
        $this->busSeats = $busSeats;
        $this->seats=$seats;
    }   
    
    public function getAllViewSeats($request)
    { 

        $busId = $request['busId'];
        // $result['viewSeats_arr'] =  $this->bus
        // ->with('busSeatLayout.seats.busSeats')
        // ->where('id', $busId)
        // ->get();
        $result['bus']=$busRecord=$this->bus->where('id',$busId)->get(['id','name','bus_seat_layout_id']);
        $result['lower_berth']=$this->seats
        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
        ->where('berthType','1')
        ->with('busSeats')
        ->get();

        $rowsColumns  =$this->seats
        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
        ->where('berthType', '1');
        $result['lowerBerth_totalRows']=$rowsColumns->max('rowNumber');       
        $result['lowerBerth_totalColumns']=$rowsColumns->max('colNumber');

        $result['upper_berth']=$this->seats
        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
        ->where('berthType','2')
        ->with('busSeats')
        ->get();

        $rowsColumns  =$this->seats
        ->where('bus_seat_layout_id',$busRecord[0]->bus_seat_layout_id)
        ->where('berthType', '2');
        $result['upperBerth_totalRows']=$rowsColumns->max('rowNumber');       
        $result['upperBerth_totalColumns']=$rowsColumns->max('colNumber');
        return $result;
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