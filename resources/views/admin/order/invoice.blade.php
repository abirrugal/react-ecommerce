
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="different types of invoice/bill/tally designed with friendly and markup using modern technology, you can use it on any type of website invoice, fully responsive and w3 validated.">
    <meta name="keywords" content="bill , receipt, tally, invoice, cash memo, invoice html, invoice pdf, invoice print, invoice templates, multipurpose invoice, template, booking invoice, general invoice, clean invoice, catalog, estimate, proposal">
    <meta name="author" content="initTheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> invoice</title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="{{ asset('invoice/images/icon/favicon.png') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('invoice/css/main-style.css') }}">
</head>
<body class="section-bg-one">
    <main class="container invoice-wrapper" id="download-section">
        <!-- invoice Top -->
        <div class="row justify-content-between">
            <div class="col-sm-3">
                <div class="invoice-logo mb-4">
                    <a href="/"><img src="{{ asset('images/logo/logo.png') }}"  class="img-thumbnail"></a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="invoice-details mb-3">
                    <h4 class="invoice-details-title text-18 mb-15">Information</h4>
                    <div class="invoice-details-inner">
                        <p class="invoice-details-para"> <strong>Address :</strong> Street name, United States.</p>
                        <p class="invoice-details-para"><strong>Call :</strong> +1-908-567-0987</p>
                        <p class="invoice-details-para"><strong>E-mail :</strong> info@domain.com</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 text-align-start text-sm-end mb-4">
                <div class="invoice-details mb-3">
                    <h4 class="invoice-details-title text-18 mb-15">Payment </h4>
                    <div class="invoice-details-inner">
                        <p class="invoice-details-para"><strong>Invoice Id : </strong> {{ $order->order_id }}</p>
                        <p class="invoice-details-para"><strong>Payment Status :</strong>  Paid </p>
                        <p class="invoice-details-para"><strong>Purchase:</strong> {{ $order->created_at->toDayDateTimeString() }} </p>
                        <p class="invoice-details-para"><strong>Address: </strong> {{ $order->detail->order_address->address }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- invoice Table -->
        <div class="table-responsive invoice-table mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Unit Cost</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>${{ $order->total_price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ $order->total_price * $item->quantity}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-7 col-sm-4"></div>
            <div class="col-lg-5 col-md-6 col-sm-7 ms-auto">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="status">Subtotal</strong>
                            </td>
                            <td>${{ $order->total_price * $item->quantity}}</td>
                        </tr>
                        <tr>
                            @php
                                $amount = ($order->total_price - $order->discount) * $item->quantity ;
                                $originalPrice =  $order->total_price * $item->quantity  ;
                                $vatRate = 0.10;
                                $totalPrice = $originalPrice + ($originalPrice * $vatRate);
                                $shippingCharge = 50;
                                $total = ($totalPrice + $shippingCharge);
                            @endphp
                            <tr>
                                <td>
                                    <strong class="status">Discount (%)</strong>
                                </td>
                                @if ($order->discount == NULL)
                                    <td>- $0</td>
                                @else
                                    <td>- ${{ round($amount) }}</td>
                                @endif
                            </tr>
                        </tr>
                        <tr>
                            <td>
                                <strong class="status">VAT (10%)</strong>
                            </td>
                            <td>+ ${{ round($totalPrice -  $originalPrice) }}</td>
                        </tr>

                        <tr>
                            <td>
                                <strong class="status">Shipping Charge</strong>
                            </td>
                            <td>+ $50</td>
                        </tr>

                        <tr>
                            <td class="border-bottom-0">
                                <strong>Total</strong>
                            </td>

                            <td class="border-bottom-0">
                                @if ($order->discount == NULL)
                                    <strong>${{ round($total) }}</strong>
                                @else
                                    <strong>${{ round(($totalPrice + $shippingCharge ) - $amount) }}</strong>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- invoice Bottom  -->
    <div class="text-center mt-5 mb-4 regular-button">
        <div class="d-print-none d-flex justify-content-center flex-wrap gap-10">
            <button id="bill-download" class="btn-primary-outline">Download</button>
            <a href="javascript:window.print()" class="btn-primary-fill">Print Invoice</a>
        </div>
    </div>

    <!-- jquery-->
    <script src="{{ asset('invoice') }}/js/jquery-3.7.0.min.js"></script>
    <!-- Plugin -->
    <script src="{{ asset('invoice') }}/js/plugin.js"></script>
    <!-- Main js-->
    <script src="{{ asset('invoice') }}/js/mian.js"></script>
</body>
</html>
