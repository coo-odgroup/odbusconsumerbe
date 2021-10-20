<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Slider;
use App\Models\Coupon;
use App\Models\CouponAssignedBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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

        $busOffers = $this->slider->where('occassion', $busOffer)->get();
        $festiveOffers = $this->slider->where('occassion',$festiveOffer)->get();
        $allOffers = $this->slider->get();

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