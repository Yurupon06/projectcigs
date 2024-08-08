<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'payment_date',	
        'amount',	
        'amount_given',	
        'change',	
        'qr_token',	
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
