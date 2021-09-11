<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BusSeats;
use App\Models\TicketPrice;
use App\Models\BusLocationSequence;
use App\Models\BookingSequence;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Arr;

class BookTicketRepository
{
    protected $bus;
    protected $ticketPrice;
    protected $location;
    protected $users;
    protected $booking;
    protected $busSeats;
    protected $busLocationSequence;

    public function __construct(Bus $bus,TicketPrice $ticketPrice,Location $location,Users $users,BusSeats $busSeats,Booking $booking,BusLocationSequence $busLocationSequence,ChannelRepository $channelRepository)
    {
        $this->bus = $bus;
        $this->ticketPrice = $ticketPrice;
        $this->location = $location;
        $this->users = $users;
        $this->busSeats = $busSeats;
        $this->booking = $booking;
        $this->channelRepository = $channelRepository;
        $this->busLocationSequence = $busLocationSequence;
        
    }   
    
    public function bookTicket($request)
    { 
        $customerInfo = $request['customerInfo'];
        $existingUser = $this->users->where('phone',$customerInfo['phone'])
                                //->orWhere('email', $customerInfo['email'])
                                ->exists(); 
        if($existingUser==true){
            $userId = $this->users->where('phone',$customerInfo['phone'])
                            //->orWhere('email',$customerInfo['email'])
                            ->first('id');
           $this->users->whereIn('id', $userId)->update($customerInfo);     
        }
        else{
            $userId = $this->users->create($request['customerInfo'])->latest('id')->first('id');   
        }
        
        $bookingInfo = $request['bookingInfo'];

        //Save Booking 
        $booking = new $this->booking;
        do {
           $transactionId = date('YmdHis') . gettimeofday()['usec'];
           } while ( $booking ->where('transaction_id', $transactionId )->exists());
        $booking->transaction_id =  $transactionId;
        do {
            $PNR = substr(str_shuffle("0123456789"), 0, 8);
            //$PNR = 'OD'."".substr(str_shuffle("0123456789"), 0, 8);
            } while ( $booking ->where('pnr', $PNR )->exists()); 
        $booking->pnr = $PNR;
        $booking->bus_id = $bookingInfo['bus_id'];
        $busId = $bookingInfo['bus_id'];
        $booking->source_id = $bookingInfo['source_id'];
        $booking->destination_id =  $bookingInfo['destination_id'];
        $j_day = $this->ticketPrice->where('bus_id',$busId)->pluck('j_day');
        $booking->j_day = $j_day[0];
        //$booking->j_day = $bookingInfo['j_day'];
        $booking->journey_dt = $bookingInfo['journey_dt'];
        $booking->boarding_point = $bookingInfo['boarding_point'];
        $booking->dropping_point = $bookingInfo['dropping_point'];
        $booking->boarding_time = $bookingInfo['boarding_time'];
        $booking->dropping_time =  $bookingInfo['dropping_time'];
        $booking->origin = $bookingInfo['origin'];
        $booking->app_type = $bookingInfo['app_type'];
        $booking->typ_id = $bookingInfo['typ_id'];
        $booking->created_by = $bookingInfo['created_by'];

        $userId->booking()->save($booking);
        
        //fetch the sequence from bus_locaton_sequence
        $seq_no_start = $this->busLocationSequence->where('bus_id',$busId)->where('location_id',$bookingInfo['source_id'])->first()->sequence;
        $seq_no_end = $this->busLocationSequence->where('bus_id',$busId)->where('location_id',$bookingInfo['destination_id'])->first()->sequence;
        
        $bookingSequence = new BookingSequence;
        $bookingSequence->sequence_start_no = $seq_no_start;
        $bookingSequence->sequence_end_no = $seq_no_end;
            
        $booking->bookingSequence()->save($bookingSequence);

        //Update Booking Details >>>>>>>>>>
        $sourceId = $bookingInfo['source_id'];
        $destinationId = $bookingInfo['destination_id'];
       
        $ticketPriceId = $this->ticketPrice
                             ->where('source_id',$sourceId)
                             ->where('destination_id',$destinationId)->first()->id;

        $bookingDetail = $request['bookingInfo']['bookingDetail'];
        $seatIds = Arr::pluck($bookingDetail, 'bus_seats_id');
        foreach ($seatIds as $seatId){
            $busSeatsId[] = $this->busSeats
                ->where('bus_id',$busId)
                ->where('ticket_price_id',$ticketPriceId)
                ->where('seats_id',$seatId)->first()->id;
        }  
        $bookingDetailModels = [];  
        $i=0;
       foreach ($bookingInfo['bookingDetail'] as $bDetail) {
            $collection= collect($bDetail);
            $merged = ($collection->merge(['bus_seats_id' => $busSeatsId[$i]]))->toArray();
            $bookingDetailModels[] = new BookingDetail($merged);
            $i++;
        }    
        $booking->bookingDetail()->saveMany($bookingDetailModels);      
        return $booking; 
       
    }
}