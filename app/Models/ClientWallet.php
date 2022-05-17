<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientWallet extends Model
{
    use HasFactory; 
    protected $table = 'client_wallet';
    protected $fillable = ['transaction_id','booking_id','reference_id','payment_via','amount','transaction_type','balance','user_id'];
    
}
