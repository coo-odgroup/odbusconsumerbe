<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;
    protected $table = 'customer_payment'; 
    protected $fillable = ['name','amount','payment_id','razorpay_id','payment_done'];
}
