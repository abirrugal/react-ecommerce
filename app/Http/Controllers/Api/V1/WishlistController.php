<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Resources\V1\WishListResource;

class WishlistController extends Controller
{
    public function index()
    {
        $products = Wishlist::with('product')->with('product.category')->with('product.subcategory')->where('user_id', auth()->id())->paginate($this::ITEM_PER_PAGE);

        return apiResourceResponse(WishListResource::collection($products), 'Wishlist');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = request()->product_id;

        $check = auth()->user()->wishList?->where('product_id', $productId)->first();

        if($check) {
            return errorResponse('This item is already in your wishlist', 400);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ]);

        return successResponse('Added to wishlist',200);
    }

    public function delete($product_id)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product_id)
            ->first();

        if(!$wishlist) {
            return errorResponse('You have not added this product to your wishlist!', 404);
        }

        $wishlist->delete();

        return successResponse('Product removed from wishlist.');
    }
}
