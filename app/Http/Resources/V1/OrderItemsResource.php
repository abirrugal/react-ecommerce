<?php

namespace App\Http\Resources\V1;

use App\Models\OrderAttribute;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
    public function toArray($request)
    {
        $variants = $this->variants;
        $additional_price = $variants->sum('additional_price') * $this->quantity;

        return [
            'id' => $this->id,
            'product_id' => $this->product->id,
            'product_slug' => $this->product->slug,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_price' => $this->discount_price,
            'additional_price' => $additional_price,
            'total' => ($this->discount_price * $this->quantity) + $additional_price,
            'image' => getImageUrl($this->product->image),
            'variants' => OrderVariantResource::collection($this->variants),
        ];
    }
}
