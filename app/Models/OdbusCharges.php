<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdbusCharges extends Model
{
    use HasFactory;
    protected $table = 'odbus_charges';
    protected $fillable = ['payment_gateway_charges','email_sms_charges','odbus_gst_charges','created_by'];
 
                        
}
