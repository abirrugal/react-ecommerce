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
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index (){

        $products = Product::where('status','1')->latest()->paginate(15);

        return Inertia::render('Product/Form');

        // return view('admin.product.index',compact('products'));
    }


    public function add(){

        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();

        return view('admin.product.create',compact('brands','categories'));
    }


    public function store(Request $request){
        //dd($request->all());
        $image = $request->file('image');
        $name_gen = time().'.'.$image->getClientOriginalExtension();
        $save_url = 'images/products/'.$name_gen;

        $image->move(public_path('images/products'), $name_gen);

        $product_id = Product::insertGetId([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock_in' => $request->stock_in,
            'discount' => $request->discount,
            'image' => $save_url,
        ]);

        $attribute_names = $request->attribute_names;
        $attribute_values = $request->attribute_values;
        $additional_prices = $request->additional_prices;
        $attribute_count = count($attribute_names);

        for($i=0; $i<$attribute_count; $i++) {
            ProductAttribute::create([
                'product_id' => $product_id,
                'name' => $attribute_names[$i],
                'value' => $attribute_values[$i],
                'additional_price' => $additional_prices[$i]
            ]);
        }

        // Multiple Image Store
        $images = $request->file('images');
        foreach ($images as $img) {

            $image = rand().'.'.$img->getClientOriginalExtension();
            $uploadPath = 'images/products/'.$image;

            $img->move(public_path('images/products'), $image);

            ProductImage::insert([
                'product_id' => $product_id,
                'image' => $uploadPath,
            ]);
        }

       $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product')->with($notification);
    }

    public function edit($id)
    {
        $images = ProductImage::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $product = Product::findOrFail($id);

        return view('admin.product.edit',compact('images','brands','categories','subcategories','product'));
    }

    public function show(Product $product)
    {
        $product->load( 'brand', 'category', 'images', 'reviews.user', 'subcategory');

        $review_count = $product->reviews->count();
        $average = $product->reviews->avg('rating');
        $average = number_format($average, 1);
        $reviews = $product->reviews->take(3);

        $product_attributes = $product->formatAttributes($product->attributes);

        return view('admin.product.show',compact('product', 'product_attributes', 'reviews', 'review_count', 'average'));
    }


    public function update(Request $request){

        $cat_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $save_url = 'images/products/'.$name_gen;

            $image->move(public_path('images/products'), $name_gen);

        if (file_exists($old_img)) {
           unlink($old_img);
        }

        Product::findOrFail($cat_id)->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock_in' => $request->stock_in,
            'discount' => $request->discount,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Product Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product')->with($notification);

        } else {

            Product::findOrFail($cat_id)->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock_in' => $request->stock_in,
            'discount' => $request->discount,
        ]);

        $notification = array(
            'message' => 'Product Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product')->with($notification);
        }
    }

    public function multiImageUpdate (Request $request){
        $imgs = $request ->images;
        foreach ($imgs as $id => $img) {
            $imgDel = ProductImage::findOrFail($id);
            unlink($imgDel->image);

            $image = rand().'.'.$img->getClientOriginalExtension();
            $uploadPath = 'images/products/'.$image;

            $img->move(public_path('images/products'), $image);

            ProductImage::where('id',$id)->update([
                'image' => $uploadPath,
            ]);
            $notification=array(
                'message'=>'Product Multiple Image Update Successfully ',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }
    }

        // MultiImage Delete ---------------------------------------------------------------------

        public function multiImageDelete ($id){
            $oldImg = ProductImage::findOrFail($id);
            unlink($oldImg->image);
            ProductImage::findOrFail($id)->delete();
            $notification=array(
                'message'=>'Product Multiple Image Delete Successfully ',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        } // end method


    // Product Inactive -----------------------------------------------
    public function productInactive($id){
        Product::findOrFail($id)->Update(['status' => 0]);
        $notification=array(
            'message'=>'Product InActive Successfully ',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function productAllInactive (){

        $products = Product::where('status','0')->latest()->paginate(15);
        return view('admin.product.inactive',compact('products'));
    }
}
