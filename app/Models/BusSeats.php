<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;


class BusSeats extends Model
{
    use HasFactory;
    protected $table = 'bus_seats';
    protected $fillable = ['bus_id', 'category','seat_type','berth_type','seat_number','duration','bookStatus','created_by'];
    public function bus()
    {
    	return $this->belongsTo(Bus::class);
    }
}
