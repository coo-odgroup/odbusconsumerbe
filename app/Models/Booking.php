<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bus;
class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = ['transaction_id','pnr','booking_customer_id','bus_operator_id','bus_id','source_id',
                            'destination_id','j_day','journey_dt','boarding_id','dropping_id',
                            'boarding_time','dropping_time',
                            'total_fare','ownr_fare','is_coupon','coupon_code','coupon_discount',
                            'discounted_fare','origin','app_type','typ_id','created_by'];

      public function bookingCustomer()
      {
            return $this->belongsTo(BookingCustomer::class);
      }

      public function bus()
      {
            return $this->belongsTo(Bus::class);
      }

      public function bookingDetail()
      {
            return $this->hasMany(BookingDetail::class);   
      } 

}
