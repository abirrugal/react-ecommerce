<?php

namespace App\Http\Resources\V1;

use App\Enums\AddressTypes;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\DeliveryMethod;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'total_price' => $this->total_price,
            'delivery_charge' => $this->delivery_charge,
            'sub_total' => $this->total_price + $this->delivery_charge,
            'status' => OrderStatus::from($this->status)->title(),
            'billing_address' => OrderBillingInfoResource::make($this->detail),
            'user_address' => UserAddressResource::make($this->detail?->order_address),
            'user_details' => UserResource::make($this->user),
            'items' => OrderItemsResource::collection($this->items),
            'payment_status' => PaymentStatus::from($this->payment_status)->title(),
            'payment_method' => $this->payment_method?->name,
            'delivery_method_id' => $this->delivery_method?->name,
            'created_at' => $this->created_at->format('d-m-Y')
        ];
    }
}
