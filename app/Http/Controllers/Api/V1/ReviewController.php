<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ReviewResource;
use App\Models\Review;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use Upload;

    public function index()
    {
        $reviews = Review::with('images')->latest()->get();

        return apiResourceResponse(ReviewResource::collection($reviews), 'Review list');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id', 'integer'],
            'review' => ['string', 'required', 'min:5'],
            'rating' => ['required', 'in:1,2,3,4,5', 'integer'],
            'gallery' => ['required', 'array'],
            'gallery.*' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first(), 422);
        }

        $reviewCheck = Review::where(['user_id' => auth()->id(), 'product_id' => $request->product_id])->first();

        if ($reviewCheck) {
            $reviewCheck->update([
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            if (isset($request->gallery)) {

                if ($reviewCheck->images) {
                    foreach ($reviewCheck->images as $image) {
                        $this->deleteFile($image->image);
                        $image->delete();
                    }
                }

                foreach ($request->gallery as $image) {
                    $image = $this->uploadFile($image, 'review');
                    $reviewCheck->images()->create([
                        'image' => $image
                    ]);
                }
            }

            return successResponse('Review submitted');
        }

        $review = auth()->user()->review()->create([
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        if (isset($request->gallery)) {

            foreach ($request->gallery as $image) {
                $image = $this->uploadFile($image, 'review');
                $review->images()->create([
                    'image' => $image
                ]);
            }
        }

        return successResponse('Review updated');
    }
}
