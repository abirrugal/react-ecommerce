<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'inside_dhaka' => $this->inside_dhaka,
            'outside_dhaka' => $this->outside_dhaka,
            'logo' => getImageUrl($this->logo),
            'app_title' => $this->app_title,
        ];
    }
}
