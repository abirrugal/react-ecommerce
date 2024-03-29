<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'image' => getImageUrl($this->image),
            'subcategories' => SubCategoryResource::collection($this->whenLoaded('subcategories')),
        ];
    }
}
