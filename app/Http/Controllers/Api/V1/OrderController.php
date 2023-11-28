<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Models\UserAddress;
use App\Enums\AddressTypes;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $availableStatuses = OrderStatus::available_statuses();

        if ($status && !in_array($status, $availableStatuses)) {
            return errorResponse('Order status must be: ' . implode(', ', $availableStatuses), 422);
        }

        $orders = Order::when($status, function ($q) use ($status) {
            $q->where('status', OrderStatus::findValue($status));
        })->where('user_id', auth()->id())
            ->latest()
            ->paginate($this::ITEM_PER_PAGE);

        return apiResourceResponse(OrderResource::collection($orders));
    }

    public function order(OrderStoreRequest $request)
    {
        if (is_null($request->user_address_id)) {

            $validator = Validator::make($request->all(), [
                'region' => 'required',
                'address' => 'required|min:5',
                'city' => 'required',
                'area' => 'required',
                'phone' => 'required|digits_between:11,15|numeric',
            ]);

            if ($validator->fails()) {
                return  errorResponse($validator->errors()->first(), 422);
            }
        }

        $total_price = 0;

        //Delivery charge
        $charge = $request->delivery_place == true ? 'inside_dhaka':'outside_dhaka';
        $deliveryCharge = Setting::first()->$charge;

        $products = json_decode($request->products);
        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_method_id' => $request->payment_method_id,
            'delivery_charge' => $deliveryCharge,
        ]);

        $order->order_id = 'Inv' . time() . $order->id;
        $order->save();

        if ($request->user_address_id) {
            $order->detail()->create([
                'order_id' => $order->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_address_id' => $request->user_address_id,
            ]);
        } else {
            $userAddress = UserAddress::create([
                'region' => $request->region,
                'address' => $request->address,
                'city' => $request->city,
                'area' => $request->area,
                'phone' => $request->phone,
                'user_id'  => auth()->id(),
                'address_type'  => AddressTypes::HOME,
            ]);

            $order->detail()->create([
                'order_id' => $order->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_address_id' => $userAddress->id,
            ]);
        }

        foreach ($products as $product) {

            $productDetails = Product::find($product->product_id);

            if ($productDetails) {
                $orderItem = $order->items()->create([
                    'product_id' => $productDetails->id,
                    'name' => $productDetails->name,
                    'quantity' => $product->quantity,
                    'price' => $productDetails->price,
                    'discount' => $productDetails->discount,
                    'discount_price' => intval($productDetails->price - ($productDetails->price / 100 *  $productDetails->discount)),
                ]);
                //Total price = product's discounted price * quantity
                $total_price += intval($productDetails->price - ($productDetails->price / 100 *  $productDetails->discount)) * $orderItem->quantity ;

                foreach ($product->variants as $id) {
                    $attrDetails = ProductAttribute::find($id);
                    $orderItem->variants()->create([
                        'product_attribute_id' => $attrDetails->id,
                        'name' => $attrDetails->name,
                        'value' => $attrDetails->value,
                        'additional_price' => $attrDetails->additional_price,
                    ]);
                  //Add additional price with total price (TotalPrice = TotalPrice + Additional price * quantity)
                    $total_price += ($attrDetails->additional_price * $orderItem->quantity);
                }
            }
        }

        $deliveryCharge = $deliveryCharge;
        $order->total_price = $total_price;
        $order->save();

        return successResponse("Order created successfully");
    }

    public function ItemsPriceCalculation($items)
    {
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item->quantity * $item->discount_price;
        }
        return $totalPrice;
    }

    public function show(Order $order)
    {
        if (auth()->id() != $order->user_id) {
            return errorResponse('Order not found!', 404);
        }

        $order->load('items.variants');

        return apiResponse(OrderResource::make($order));
    }

    public function orderCancel(Order $order)
    {
        if (auth()->id() != $order->user_id) {
            return errorResponse('Order not found!', 404);
        }
        $order->status = OrderStatus::CANCELLED;
        $order->save();

        return successResponse('Order Cancelled');
    }
}
