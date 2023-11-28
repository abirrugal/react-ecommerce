<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Http\Resources\V1\CartItemsResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        // $cart = Cart::with('items')->where('user_id', auth()->id())->first();
        $cart = auth()->user()->cart;

        return apiResourceResponse(CartItemsResource::collection($cart->items ?? []), 'Cart List');
    }

    public function store(CartStoreRequest $request)
    {
        $cart = auth()->user()->cart;

        if ($cart) {

            $checkItem = $cart?->items()->where('product_id', $request->product_id)->first();

            if ($checkItem) {
                $checkItem->update([
                    'price' => $request->price,
                    'quantity' => $checkItem->quantity +  $request->quantity,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                ]);
            }

            return successResponse('Product Added To Cart Successfully');
        }

        $newcart = Cart::create([
            'user_id' => auth()->id(),
        ]);

        $newcart->items()->create([
            'product_id' => $request->product_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return successResponse('Product Added To Cart Successfully');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first(),422);
        }

        //Only authenticated user can update.
        $cartItem = auth()->user()->cart?->items->where('id', $cartItem->id)->first();
        if (is_null($cartItem))
            return errorResponse('Permission Denied',401);

        $cartItem->update([
            'quantity' =>  $request->quantity,
        ]);

        return successResponse('Cart Updated Successfully');
    }

    public function delete(CartItem $cartItem)
    {
        //Only authenticated user can delete.
        $cartItem = auth()->user()->cart?->items->where('id', $cartItem->id)->first();
        if (is_null($cartItem))
            return errorResponse('Permission Denied', 401);
        $cartItem->delete();

        return successResponse('Cart deleted');
    }
}
