<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class BookingCustomer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'phone',
        'email',
        'created_by',
    ];
    public function booking()
      {
            return $this->hasOne(Booking::class);   
      } 

}
