<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderBillingInfoResource extends JsonResource
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
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'phone'=> $this->phone,
            'email'=> $this->email,
            'region'=> $this->region,
            'address'=> $this->address,
            'area'=> $this->area,
        ];
    }
}
