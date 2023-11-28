<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id','DESC')->paginate(15);

        return view('admin.order.index',compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'payment_method');

        return view('admin.order.show',compact('order'));
    }

    public function invoice(Order $order){

        $order->load('items.product', 'payment_method', 'detail.order_address');

        return view('admin.order.invoice', compact('order'));
    }
}
