<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'review' => $this->review,
            'rating' => $this->rating,
            'user_name' => $this->user->username,
            'create_time' => $this->created_at->format('d-m-Y'),
            'update_time' => $this->updated_at->format('d-m-Y'),
            'images' => $this->galleryResource($this->images),
        ];

    }

    private function galleryResource($images=[])
    {
        $data = [];
        foreach($images as $image) {
            $data[] = getImageUrl($image->image);
        }
        return $data;
    }
}
