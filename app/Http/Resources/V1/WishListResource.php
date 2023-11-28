<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => ProductResource::make($this->product),
        ];
    }
}