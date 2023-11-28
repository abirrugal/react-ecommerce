<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(){

        $brands = Brand::latest()->paginate(15);

        return view('admin.brand.index',compact('brands'));
    }


    public function add(){

        return view('admin.brand.create');
    }


    public function store(Request $request){

        $image = $request->file('image');
        $name_gen = time().'.'.$image->getClientOriginalExtension();
        $save_url = 'images/brand/'.$name_gen;
        $image->move(public_path('images/brand'), $name_gen);

        Brand::insert([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'description' => $request->description,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Brand Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);
    }


    public function edit($id){

        $brand = Brand::findOrFail($id);

        return view('admin.brand.edit',compact('brand'));
    }


    public function update(Request $request){

        $cat_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $save_url = 'images/brand/'.$name_gen;

            $image->move(public_path('images/brand'), $name_gen);

        if (file_exists($old_img)) {
           unlink($old_img);
        }

        Brand::findOrFail($cat_id)->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'description' => $request->description,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Brand Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);

        } else {

             Brand::findOrFail($cat_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-',$request->name)),
                'description' => $request->description,
        ]);

        $notification = array(
            'message' => 'Brand Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);
        }
    }


    public function delete($id){

        $brand = Brand::findOrFail($id);
        $img = $brand->image;
        unlink($img );

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);
    }
}
