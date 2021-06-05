<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;
    protected $table = 'customer_notification'; 
    protected $fillable = [
        'sender', 'receiver', 'contents','channel_type','acknowledgement'
    ];
}
