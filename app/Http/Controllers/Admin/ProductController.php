<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Variant;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->search) {
            $products = $products->where('name', 'LIKE', "%{$request->search}%");
        }
        $products = $products->latest()->paginate(15);

        return Inertia::render('Product/Index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $variants = Variant::latest('name')->get();

        return Inertia::render('Product/Create',  ['brands' => $brands, 'categories' => $categories, 'variants' => $variants]);
    }

    public function store(Request $request)
    {
        $inputs =  $request->validate([
            'name' => 'required|min:2',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'subcategory_id' => 'required|numeric|exists:sub_categories,id',
            'brand_id' => 'nullable|numeric|exists:brands,id',
            'description' => 'required|min:2|string',
            'variant' => 'nullable',
            'price' => 'required|numeric',
            'stock_in' => 'required|numeric',
            'discount' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048',
            'images' => 'required',
            'status' => 'required'
        ]);

        $image = $request->file('image');

        if ($image) {
            $name_gen = time() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/products/' . $name_gen;
            $image->move(public_path('images/products'), $name_gen);
            $inputs['image'] = $save_url;
        }
        $inputs['slug'] = strtolower(str_replace(' ', '-', $request->name));
        $product = Product::create($inputs);
        $variants = $request->variant;
        if (!empty($variants)) {
            foreach ($variants as $key => $value) {
                $product->variants()->create([
                    'name' => $value['attributeName'],
                    'value' => $value['attributeValue'],
                    'additional_price' => $value['additionalPrice']
                ]);
            }
        }
        foreach ($request->images as $key => $image) {
            $name_gen = uniqid() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/products/gallery/' . $name_gen;
            $image->move(public_path('images/products/gallery'), $name_gen);
            $image = $save_url;

            $product->images()->create(['image' => $image]);
        }

        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $variants = Variant::latest('name')->get();
        $product = Product::with(['category', 'subcategory', 'brand', 'images', 'variants'])->findOrFail($id);

        return Inertia::render('Product/Edit', ['product' => $product, 'categories' => $categories, 'subcategories' => $subcategories, 'brands' => $brands, 'variants' => $variants]);
    }

    public function show(Product $product)
    {
        $product->load('brand', 'category', 'images', 'reviews.user', 'subcategory');

        $review_count = $product->reviews->count();
        $average = $product->reviews->avg('rating');
        $average = number_format($average, 1);
        $reviews = $product->reviews->take(3);
        $product_attributes = $product->formatAttributes($product->attributes);

        return view('admin.product.show', compact('product', 'product_attributes', 'reviews', 'review_count', 'average'));
    }


    public function update(Request $request, $id)
    {
        $inputs =  $request->validate([
            'name' => 'required|min:2',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'subcategory_id' => 'required|numeric|exists:sub_categories,id',
            'brand_id' => 'nullable|numeric|exists:brands,id',
            'description' => 'required|min:2|string',
            'variant' => 'nullable',
            'price' => 'required|numeric',
            'stock_in' => 'required|numeric',
            'discount' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048',
            'status' => 'required'
            // 'images' => 'required',
        ]);

        $product = Product::find($id);

        if ($product) {
            $image = $request->file('image');
            if ($image) {
                if (file_exists($product->image)) {
                    unlink($product->image);
                }
                $name_gen = time() . '.' . $image->getClientOriginalExtension();
                $save_url = 'images/products/' . $name_gen;
                $image->move(public_path('images/products'), $name_gen);
                $inputs['image'] = $save_url;
            }
            $product->update($inputs);
            $variants = $request->variant;
            if ($variants) {
                $product->variants()->delete();
                foreach ($variants as $key => $value) {
                    $product->variants()->create([
                        'name' => $value['attributeName'],
                        'value' => $value['attributeValue'],
                        'additional_price' => $value['additionalPrice']
                    ]);
                }
            }
        }

        return redirect()->route('product.index');
    }

    public function addImage(Request $request, $id)
    {
        $product = Product::find($id);

        foreach ($request->images as $key => $image) {
            $name_gen = uniqid() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/products/gallery/' . $name_gen;
            $image->move(public_path('images/products/gallery'), $name_gen);
            $image = $save_url;

            $product->images()->create(['image' => $image]);
        }

        return redirect()->back();
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if (file_exists($image->image)) {
            unlink($image->image);
        }
        $image->delete();

        return redirect()->back();
    }
}
