<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Slider;
use App\Models\Coupon;
use App\Models\CouponAssignedBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OfferRepository
{
    protected $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;  
    }   
    
    public function offers($request)
    { 
        $busOffer = Config::get('constants.Bus_Offers');
        $festiveOffer = Config::get('constants.Festive_Offers');
        $busOperatorId = $request['bus_operator_id'];
      
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        // $busOff = $this->slider->where('occassion', $busOffer)
        //                           ->get();
        // $startDate = $busOff[0]->start_date;
        // $endDate = $busOff[0]->end_date;
        
        // if (($currentDate >= $startDate) && ($currentDate <= $endDate)){  
        //     $busOffers = $this->slider->where('occassion', $busOffer)
        //                               ->get();
        // }else{
        //      return "not applicable";
        // }

        $busOffers = $this->slider->where('occassion', $busOffer)
                                  ->where('bus_operator_id', $busOperatorId)
          						  ->where('start_date','<=',$currentDate)
                                  ->where('end_date','>=',$currentDate)
                                  ->where('status',1)
                                  ->get();    
        $festiveOffers = $this->slider->where('occassion',$festiveOffer)
                                      ->where('bus_operator_id', $busOperatorId)
          							  ->where('start_date','<=',$currentDate)
                                      ->where('end_date','>=',$currentDate)	
          							  ->where('status',1)		
                                      ->get();

        $allOffers = $this->slider->where('bus_operator_id', $busOperatorId)
                                  ->where('start_date','<=',$currentDate)
                                  ->where('end_date','>=',$currentDate)
                                  ->where('status',1)
                                  ->get();

        $offers = array(
            "busOffers" => $busOffers, 
            "festiveOffers" => $festiveOffers, 
            "allOffers" => $allOffers
        );
        return $offers;    
    }
    public function coupons($request)
    {   
        $busId = $request['busId'];
        $sourceId = $request['sourceId'];
        $destId = $request['destinationId'];
        $operatorId = Bus::where('id',$busId)->first()->bus_operator_id;
       
        $coupon = Coupon::with(['couponAssignedBus' => function ($query) use($busId) {                    
                                                        $query->where('bus_id',$busId);                     
                                                        }])
                        ->with(['couponOperator' => function ($query) use($operatorId) {                    
                                                            $query->where('operator_id',$operatorId);                     
                                                            }])
                        ->with(['couponRoute' => function ($query) use($sourceId,$destId) {                    
                                                                $query->where([
                                                                    ['source_id', $sourceId],
                                                                    ['destination_id', $destId],
                                                                ]);                    
                                                                }])
                                                        ->get();
       
        return  $coupon;
    }
      

}