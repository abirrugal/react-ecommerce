<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order_address(){
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
