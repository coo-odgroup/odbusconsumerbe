<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Bus;
class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = ['transaction_id','pnr','users_id','bus_id','source_id',
                            'destination_id','j_day','journey_dt','boarding_point','dropping_point',
                            'boarding_time','dropping_time','origin','app_type','typ_id','created_by'];

      public function users()
      {
            return $this->belongsTo(Users::class);
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
