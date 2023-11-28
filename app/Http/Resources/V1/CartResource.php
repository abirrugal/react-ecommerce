<?php

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'items'=> CartItemsResource::collection($this->items),
        ];
    }
}
