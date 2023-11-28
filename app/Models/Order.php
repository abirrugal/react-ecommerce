<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function detail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function delivery_charge()
    {
        return $this->belongsTo(DeliveryCharge::class);
    }

    public function proccessed_by()
    {
        return $this->hasOne(User::class, 'id', 'processed_by');
    }

}
