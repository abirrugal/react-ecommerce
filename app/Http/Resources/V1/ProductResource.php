<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'subcategory' => SubCategoryResource::make($this->whenLoaded('subcategory')),
            'description' => $this->description,
            'price' => $this->price,
            'brand' => $this->brand?->name ?? 'No brand',
            'discount' => $this->discount ?? 0,
            'discount_price' => $this->discount == null ? 0 : intval($this->price - ($this->price / 100 *  $this->discount)),
            'saved' => $this->discount == null ? 0 : intval($this->price / 100 *  $this->discount),
            'stock' => $this->stock_in - $this->stock_out,
            'rating' => $this->rating,
            'thumbnail' => getImageUrl($this->image),
            'gallery' => $this->galleryResource($this->images),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'wishlist' => $this->wishList()->where('user_id', auth()->id())->first() ? true : false,
            'variants' =>  $this->whenLoaded('variants', function () {
                return $this->formatAttributes($this->variants);
            }),

        ];
    }

    private function galleryResource($images = [])
    {
        $data = [];
        foreach ($images as $image) {
            $data[] = $image->full_image;
        }
        return $data;
    }
}
