<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlashSaleResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\V1\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|array',
            'category_slug' => 'nullable|array',
            'subcategory_slug' => 'nullable|array',
            'brand_id' => 'nullable|array',
            'brand_slug' => 'nullable|array',
            'name' => 'nullable|string',
        ]);

        $category_id = $this->filterArray($request->category_id);
        $category_slug = $this->filterArray($request->category_slug);
        $subcategory_slug = $this->filterArray($request->subcategory_slug);
        $brand_id = $this->filterArray($request->brand_id);
        $brand_slug = $this->filterArray($request->brand_slug);
        $data = [];

        $products = Product::with('category', 'subcategory', 'images', 'variants');

        if (!empty($category_id)) {
            $products =  $products->whereIn('category_id', $category_id);
        }

        if (!empty($category_slug)) {
            $categoryIds = Category::whereIn('slug', $category_slug)->pluck('id')->toArray();
            $products =  $products->whereIn('category_id', $categoryIds);
        }

        if (!empty($subcategory_slug)) {
            $subcategoryIds = SubCategory::whereIn('slug', $subcategory_slug)->pluck('id')->toArray();
            $products =  $products->whereIn('subcategory_id', $subcategoryIds);
        }

        if (!empty($brand_id)) {
            $products =  $products->whereIn('brand_id', $brand_id);
        }

        if (!empty($brand_slug)) {
            $brandIds = Brand::whereIn('slug', $brand_slug)->pluck('id')->toArray();
            $products =  $products->whereIn('brand_id', $brandIds);
        }

        if ($request->order_by_price == 0) {  //Low to High price
            $products =  $products->orderBy('price');
        }

        if ($request->order_by_price == 1) {  //High to Low price
            $products =  $products->orderBy('price', 'desc');
        }

        if ($request->rating) {
            $products = $products->where('rating', intval($request->rating));
        }

        if ($request->name) {
            $products =  $products->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->popular) {
            $products =  $products->orderBy('stock_out', 'desc');
        }

        if ($request->min_price && $request->max_price) {
            $products =  $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->flash_sale) {
            $data['flash_sale_info'] = FlashSale::where('status', 1)->where('expired_at', '>', now())->first()->makeHidden('created_at','updated_at');
            $flash_sale_id = $data['flash_sale_info'] == null ? '' : $data['flash_sale_info']->id;

            $products =  $products->where('flash_sale_id', $flash_sale_id);
        }

        $products = $products->latest()->paginate($this::ITEM_PER_PAGE);

        return apiResourceResponse(ProductResource::collection($products ?? []), null, 200, $data);
    }

    private function filterArray($array)
    {
        if (is_null($array)) return [];

        return array_values(array_filter($array));
    }

    public function productSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3']
        ]);

        if ($validator->fails()) {
            return  successResponse($validator->errors()->first(), 422);
        }
        $name = $request->name;

        $product = Product::with('category', 'subcategory', 'images', 'variants')->when($name, function ($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%');
        })->get();

        return apiResourceResponse(ProductResource::collection($product ?? []));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'subcategory_id' => ['required', 'string', 'exists:sub_categories,id'],
            'brand_id' => ['nullable', 'numeric', 'exists:brands,id'],
            'description' => ['required', 'string', 'min:2'],
            'price' => ['required', 'numeric'],
            'rating' => ['nullable', 'numeric'],
            'stock_in' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
            'gallery' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return  errorResponse($validator->errors()->first(), 422);
        }

        (new Product())->saveOrUpdate($validator);

        return successResponse('Product stored successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'subcategory_id' => ['required', 'string', 'exists:sub_categories,id'],
            'brand_id' => ['nullable', 'numeric', 'exists:brands,id'],
            'description' => ['required', 'string', 'min:2'],
            'price' => ['required', 'numeric'],
            'rating' => ['nullable', 'numeric'],
            'stock_in' => ['required', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
            'gallery' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return  errorResponse($validator->errors()->first(), 422);
        }

        (new Product())->saveOrUpdate($validator, $product);

        return successResponse('Product updated successfully.');
    }

    // public function productsByType(Request $request)
    // {
    //     $products = Product::with('category', 'subcategory', 'images');

    //     if ($request->new) {
    //         $products->latest();
    //     }

    //     $products = $products->paginate($this::ITEM_PER_PAGE);

    //     return $this->successResponse(200, 'Product list', ProductResource::collection($products ?? []));
    // }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category', 'subcategory', 'images', 'reviews', 'variants')->first();
        if (is_null($product)) {
            return errorResponse('Invalid Product', 420);
        }

        return apiResponse(ProductResource::make($product));
    }
}
