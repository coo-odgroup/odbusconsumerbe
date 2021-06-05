<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;
    protected $table = 'customer_payment'; 
    protected $fillable = [
        'sender', 'amount', 'contents','acknowledgement'
    ];
}
