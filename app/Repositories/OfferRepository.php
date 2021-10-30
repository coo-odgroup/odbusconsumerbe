<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Slider;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Users;
use App\Models\CouponAssignedBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Repositories\ListingRepository;

class OfferRepository
{
    protected $slider;
    public function __construct(Slider $slider,ListingRepository $listingRepository)
    {
        $this->slider = $slider;  
        $this->listingRepository = $listingRepository;
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

        // $busOffers = $this->slider->where('occassion', $busOffer)
        //                           ->where('bus_operator_id', $busOperatorId)
        //   						  ->where('start_date','<=',$currentDate)
        //                           ->where('end_date','>=',$currentDate)
        //                           ->where('status',1)
        //                           ->get();    
        // $festiveOffers = $this->slider->where('occassion',$festiveOffer)
        //                               ->where('bus_operator_id', $busOperatorId)
        //   							  ->where('start_date','<=',$currentDate)
        //                               ->where('end_date','>=',$currentDate)	
        //   							  ->where('status',1)		
        //                               ->get();

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
        $requestedCouponCode = $request['coupon_code'];
        $busId = $request['bus_id'];
        $sourceId = $request['source_id'];
        $destId = $request['destinatin_id'];
        $busOperatorId = $request['bus_operator_id'];
        $jDate = $request['journey_date'];
        $totalFare = $request['total_fare'];
        //$userPhone = $request['user_phone'];
        $transactionId = $request['transaction_id'];
        // $coupon = Coupon::where('bus_operator_id',$busOperatorId)
        //                 ->where('from_date', '<=', $jDate)
        //                 ->where('to_date', '>=', $jDate)

        //                 ->with(['couponAssignedBus' => function ($query) use($busId) {                    
        //                                                 $query->where('bus_id',$busId);                     
        //                                                 }])
        //                 ->with(['couponRoute' => function ($query) use($sourceId,$destId) {                    
        //                                                         $query->where([
        //                                                             ['source_id', $sourceId],
        //                                                             ['destination_id', $destId],
        //                                                         ]);                    
        //                                                         }])
        //                                                 ->pluck('coupon_code');
        
        // $existingUser = Users::where('phone',$userPhone) ->exists(); 
        //$existingUser = $userId = Users::where('phone',$userPhone)->exists();;
        
        // if($existingUser==true){
        //     $userId = Users::where('phone',$userPhone)->first()->id;  
        // }
        // else{
          
        // }     
        $userId = Booking::where('transaction_id',$transactionId)->first()->users_id;                               
        //$userId = Users::where('phone',$userPhone) ->first()->id;
        $couponCount = Booking::where('coupon_code',$requestedCouponCode)->whereIn('status',[1,2])->count('id');
                                                       
        $coupon = Coupon::where('coupon_code',$requestedCouponCode)->get();
        $maxRedeemCount = $coupon[0]->max_redeem;
        
        if($couponCount <= $maxRedeemCount){
            if(isset($coupon)){ 
                $couponType = $coupon[0]->type;  
                $maxDiscount = $coupon[0]->max_discount_price;
                if($couponType == '1'){
                    $percentage = $coupon[0]->percentage;
                    $discount = ($totalFare*($percentage))/100;
                    if($discount <=  $maxDiscount ){
                        $totalAmount = $totalFare - $discount; 
                        $couponRecords = array(
                            "totalAmount" => $totalAmount, 
                            "discount" => $discount,
                        );
                        Booking::where('users_id', $userId)->update(['coupon_code' => $requestedCouponCode]);
                        return $couponRecords;
                    }else{
                        $discount = $maxDiscount;
                        $totalAmount = $totalFare - $maxDiscount;
                        $couponRecords = array(
                            "totalAmount" => $totalAmount, 
                            "discount" => $discount,
                        );
                        Booking::where('users_id', $userId)->update(['coupon_code' => $requestedCouponCode]);
                        return $couponRecords;
                    }
                }elseif($couponType == '2'){  
                    $minTransactionAmount = $coupon[0]->min_tran_amount;
                    if($totalFare >= $minTransactionAmount ){
                        $discount = $coupon[0]->amount;
                        $totalAmount = $totalFare - $discount; 
                        $couponRecords = array(
                            "totalAmount" => $totalAmount, 
                            "discount" => $discount,
                        );
                        Booking::where('users_id', $userId)->update(['coupon_code' => $requestedCouponCode]);
                        return $couponRecords;
                    }else{
                        return "coupon is not applicable";
                    }
                }
    
            }else{
                return "invalid coupon code";
            }
        }else{
            return "coupon code expired";
        }
    }
      

}