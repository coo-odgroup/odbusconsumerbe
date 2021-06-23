<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;
use App\Models\Booking;
use App\Models\BookingCustomer;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'booking_detail';
    protected $fillable = ['booking_id','seat_no', 'passenger_name','passenger_gender','passenger_age','total_fare','owner_fare','created_by'];
                            
      public function booking()
      {
            return $this->belongsTo(Booking::class);
      }
}
