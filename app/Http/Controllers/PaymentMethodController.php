<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $deliveryMethod = PaymentMethod::latest()->get();

        return apiResourceResponse(PaymentMethodResource::collection($deliveryMethod), 'Delivery methods');
    }
}
