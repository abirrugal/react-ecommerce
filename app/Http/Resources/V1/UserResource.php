<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'role' => $this->get_role($this->role),
            'address' => AddressResource::collection($this->addresses ?? []),
        ];
    }
}
