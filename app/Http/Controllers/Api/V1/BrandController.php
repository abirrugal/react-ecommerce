<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brand = Brand::latest()->where('active', 1)->get();

        return apiResourceResponse(BrandResource::collection($brand), 'Brand list');
    }
}
