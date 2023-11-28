@extends('layouts.app')
@section('title', 'Order')
@section('content')

<div class="row mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-2">Order #{{ $order->order_id }}</h5>
                        <h6 class="card-text text-muted">Date : {{ $order->created_at->toDayDateTimeString() }}</h6>
                    </div>
                    <div>
                        <a href="{{ route('order.invoice',$order->id) }}" target="_blank" class="btn btn-primary">Invoice</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="product_details">
                    <table class="table">
                        <thead class="table-light">
                            <tr class="text-white">
                                <th scope="col">Product</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset($item->product->image) }}" style="width: 80px; height:80x;" class="img-thumbnail">
                                        <span>{{ $item->product->name }}</span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Order Summary</h5>
                <div class="product_details">
                    <table class="table">
                        <thead class="table-light">
                            <tr class="text-white">
                                <th scope="col">Descriptions</th>
                                <th scope="col">Amounts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $amount = ($order->total_price - $order->discount) * $item->quantity ;
                                $originalPrice =  $order->total_price * $item->quantity  ;
                                $vatRate = 0.10;
                                $totalPrice = $originalPrice + ($originalPrice * $vatRate);
                                $shippingCharge = 50;
                                $total = ($totalPrice + $shippingCharge);
                            @endphp
                            <tr>
                                <td>Sub Total: </td>
                                <td class="text-center">${{ $originalPrice }}</td>
                            </tr>
                            <tr>
                                <td>Discount:</td>
                                <td class="text-center">
                                    @if ($order->discount == NULL)
                                        <span>0</span>
                                    @else
                                        <span class="text-danger">${{ round($amount) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Shipping Charge :</td>
                                <td class="text-center">+ $50</td>
                            </tr>
                            <tr>
                                <td>Tax & Vat 10% (included)</td>
                                <td class="text-center"> + ${{ round($totalPrice -  $originalPrice) }}</td>
                            </tr>
                            <tr>
                                <td>Total Amount :</td>
                                @if ($order->discount == NULL)
                                    <td class="text-center">{{ round($total) }}</td>
                                @else
                                <td class="text-center">${{ round(($totalPrice + $shippingCharge ) - $amount) }} </td>
                                @endif
                            </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">Payment Details</h5>
                <div class="product_details">
                    <table class="table">
                        <thead class="table-light">
                          <tr class="text-white">
                            <th scope="col">Descriptions</th>
                            <th scope="col">Amounts</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Transactions:</td>
                                <td> hfjh</td>
                            </tr>
                            <tr>
                                <td> Payment Method:</td>
                                <td> {{ $order->payment_method->name }}</td>
                            </tr>
                            <tr>
                                <td> Card Holder Name:</td>
                                <td> hfjh</td>
                            </tr>
                            <tr>
                                <td> Card Numbar:</td>
                                <td> hfjh</td>
                            </tr>
                            <tr>
                                <td> Total Amount :</td>
                                @if ($order->discount == NULL)
                                    <td>{{ $total }}</td>
                                @else
                                <td>${{ ($totalPrice + $shippingCharge ) - $amount }} </td>
                                @endif
                            </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
