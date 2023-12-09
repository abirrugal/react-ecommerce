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
        $products = $products->where('status', '1')->latest()->paginate(15);

        return Inertia::render('Product/Index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $variants = Variant::latest('name')->get();
        return Inertia::render('Product/Create',  ['brands' => $brands, 'categories' => $categories, 'variants' => $variants]);
        // return view('admin.product.create',compact('brands','categories'));
    }

    public function store(Request $request)
    {
        $inputs =  $request->validate([
            'name' => 'required|min:2',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'subcategory_id' => 'required|numeric|exists:sub_categories,id',
            'brand_id' => 'nullable|numeric|exists:brands,id',
            'description' => 'required|min:2|string',
            'variant' => 'required',
            'price' => 'required|numeric',
            'stock_in' => 'required|numeric',
            'discount' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048',
            'images' => 'required',
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

        foreach ($variants as $key => $value) {
            $product->variants()->create([
                'name' => $value['attributeName'],
                'value' => $value['attributeValue'],
                'additional_price' => $value['additionalPrice']
            ]);
        }

        foreach ($request->images as $key => $image) {
            $name_gen = time() . '.' . $image->getClientOriginalExtension();
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
        // return view('admin.product.edit', compact('images', 'brands', 'categories', 'subcategories', 'product'));
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
            // $inputs['slug'] = strtolower(str_replace(' ', '-', $request->name));
            $product = $product->update($inputs);
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

            // foreach ($request->images as $key => $image) {
            //     $name_gen = time() . '.' . $image->getClientOriginalExtension();
            //     $save_url = 'images/products/gallery/' . $name_gen;
            //     $image->move(public_path('images/products/gallery'), $name_gen);
            //     $image = $save_url;

            //     $product->images()->create(['image' => $image]);
            // }
        }

        return redirect()->route('product.index');
    }

    public function multiImageUpdate(Request $request)
    {
        $imgs = $request->images;
        foreach ($imgs as $id => $img) {
            $imgDel = ProductImage::findOrFail($id);
            unlink($imgDel->image);

            $image = rand() . '.' . $img->getClientOriginalExtension();
            $uploadPath = 'images/products/' . $image;

            $img->move(public_path('images/products'), $image);

            ProductImage::where('id', $id)->update([
                'image' => $uploadPath,
            ]);
            $notification = array(
                'message' => 'Product Multiple Image Update Successfully ',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }
    }

    // MultiImage Delete ---------------------------------------------------------------------

    public function multiImageDelete($id)
    {
        $oldImg = ProductImage::findOrFail($id);
        unlink($oldImg->image);
        ProductImage::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Product Multiple Image Delete Successfully ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    } // end method


    // Product Inactive -----------------------------------------------
    public function productInactive($id)
    {
        Product::findOrFail($id)->Update(['status' => 0]);
        $notification = array(
            'message' => 'Product InActive Successfully ',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function productAllInactive()
    {

        $products = Product::where('status', '0')->latest()->paginate(15);
        return view('admin.product.inactive', compact('products'));
    }
}
