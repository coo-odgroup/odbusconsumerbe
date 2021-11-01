<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Slider;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Users;
use App\Models\CouponRoute;
use App\Models\CouponAssignedBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Arr;

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
            "allOffers" => $allOffers
        );
        return $offers;    
    }
    public function coupons($request)
    {   
        $requestedCouponCode = $request['coupon_code'];
        $busId = $request['bus_id'];
        $sourceId = $request['source_id'];
        $destId = $request['destination_id'];
        $busOperatorId = $request['bus_operator_id'];
        $jDate = $request['journey_date'];
        $totalFare = $request['total_fare'];
        $transactionId = $request['transaction_id'];
        $selCouponRecords = Coupon::where('status','1')->get();
        $routeCoupon = CouponRoute::where('source_id', $sourceId)
                                    ->where('destination_id', $destId)
                                    ->with('coupon')
                                    ->get();
    
             if(isset($routeCoupon[0]->coupon)){                           
                $routeCouponCode = $routeCoupon[0]->coupon->coupon_code;
             }else{
                 $routeCouponCode =[];
             } 
        $records = Bus::where('bus_operator_id', $busOperatorId)  
                        ->with('couponAssignedBus.coupon')
                        ->with('busOperator.coupon') 
                        ->where('status','1')
                        ->get();
        $busCouponCode = [];
        $opCouponCode = [];
        foreach($records as $record){        
                    if(isset($record->couponAssignedBus[0]->coupon)){                       //Bus wise coupon
                        $busCouponCode = $record->couponAssignedBus[0]->coupon->coupon_code;     
                    }
                    if(isset($record->busOperator->coupon)){                                ///operator wise coupon
                        $couponCodeRecords = $record->busOperator->coupon;
                        $opCouponCode = $couponCodeRecords->pluck('coupon_code');
                    }
                    
                    $CouponRecords = collect([$busCouponCode,$opCouponCode,$routeCouponCode]);
                    $CouponRecords = $CouponRecords->flatten()->unique()->values()->all();
        
                    ///Coupon applicable for specific date range
                    $appliedCoupon = collect([]);
                    $date = Carbon::now();
                    $bookingDate = $date->toDateString();
                    foreach($CouponRecords as $key => $coupon){
                        $type = $selCouponRecords->where('coupon_code',$coupon)->first()->valid_by;
                        switch($type){
                            case(1):    //Coupon available on journey date
                                $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                                            ->where('from_date', '<=', $jDate)
                                            ->where('to_date', '>=', $jDate)->all();           
                                break;
                            case(2):    //Coupon available on booking date
                                $dateInRange = $selCouponRecords->where('coupon_code',$coupon)
                                ->where('from_date', '<=', $bookingDate)
                                ->where('to_date', '>=', $bookingDate)->all();
                                break;      
                        }
                        if($dateInRange){
                            $appliedCoupon->push($coupon);
                         }
                    }   
        }   

    $couponExists  = $appliedCoupon->contains($requestedCouponCode);
        if($couponExists)
        {
            $userId = Booking::where('transaction_id',$transactionId)->first()->users_id;
            $couponCount = Booking::where('coupon_code',$requestedCouponCode)->whereIn('status',[1,2])->count('id');
        }else{
            return "inval_coupon";
        }                                            
        $couponDetails = Coupon::where('coupon_code',$requestedCouponCode)->get();
        $maxRedeemCount = $couponDetails[0]->max_redeem;
       
        if($couponCount <= $maxRedeemCount){
            if(isset($couponDetails)){ 
                $couponType = $couponDetails[0]->type;  
                $maxDiscount = $couponDetails[0]->max_discount_price;
              
                if($couponType == '1'){
                    $percentage = $couponDetails[0]->percentage;
                    $discount = ($totalFare*($percentage))/100;
                  
                    if($discount <=  $maxDiscount ){
                        $totalAmount = $totalFare - $discount; 
                        $couponRecords = array(
                            "totalAmount" => $totalFare, 
                            "discount" => $discount,
                            "payableAmount" => $totalAmount, 
                        );
                        Booking::where('users_id', $userId)->where('transaction_id', $transactionId)
                                                            ->update([
                                                                'coupon_code' => $requestedCouponCode,
                                                                'coupon_discount' => $discount
                                                            ]);
                                                            
                        return $couponRecords;
                    }else{
                        $discount = $maxDiscount;
                        $totalAmount = $totalFare - $maxDiscount;
                        $couponRecords = array(
                            "totalAmount" => $totalFare, 
                            "discount" => $discount,
                            "payableAmount" => $totalAmount, 
                        );
                        Booking::where('users_id', $userId)->where('transaction_id', $transactionId)
                                                            ->update([
                                                                'coupon_code' => $requestedCouponCode,
                                                                'coupon_discount' => $discount
                                                            ]);
                        return $couponRecords;
                    }
                }elseif($couponType == '2'){  
                    $minTransactionAmount = $couponDetails[0]->min_tran_amount;
                    if($totalFare >= $minTransactionAmount ){
                        $discount = $couponDetails[0]->amount;
                        $totalAmount = $totalFare - $discount; 
                        $couponRecords = array(
                            "totalAmount" => $totalFare, 
                            "discount" => $discount,
                            "payableAmount" => $totalAmount, 
                        );
                        Booking::where('users_id', $userId)->where('transaction_id', $transactionId)
                                                            ->update([
                                                                'coupon_code' => $requestedCouponCode,
                                                                'coupon_discount' => $discount
                                                            ]);
                        return $couponRecords;
                    }else{
                        return "min_tran_amount";
                    }
                }
    
            }else{
                return "inval_coupon";
            }
        }else{
            return "coupon_expired";
        }
    }
      

}