<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Slider;
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
      

}