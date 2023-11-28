<?php

namespace App\Http\Resources\V1;

use App\Enums\AddressTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'region' => $this->region,
            'address' => $this->address,
            'area' => $this->area,
            'phone' => $this->phone,
            'city' => $this->city,
            'address_type' => AddressTypes::from($this->address_type)->title(),
        ];
    }
}
