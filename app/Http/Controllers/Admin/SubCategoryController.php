<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function index(){

        $subcategories = SubCategory::latest()->paginate(15);

        return view('admin.subcategory.index',compact('subcategories'));
    }

    public function add(){

        $categories = Category::orderBy('name','ASC')->get();

        return view('admin.subcategory.create',compact('categories'));
    }


    public function store(Request $request){

        $image = $request->file('image');
        $name_gen = time().'.'.$image->getClientOriginalExtension();
        $save_url = 'images/subcategory/'.$name_gen;
        $image->move(public_path('images/subcategory'), $name_gen);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Sub Category Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('subcategory')->with($notification);
    }


    public function edit($id){

        $categories = Category::orderBy('name','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);

        return view('admin.subcategory.edit',compact('subcategory','categories'));
    }


    public function update(Request $request){

        $cat_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $save_url = 'images/subcategory/'.$name_gen;
            $image->move(public_path('images/subcategory'), $name_gen);

        if (file_exists($old_img)) {
           unlink($old_img);
        }

        SubCategory::findOrFail($cat_id)->update([

            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Sub Category Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('subcategory')->with($notification);

        } else {

             Category::findOrFail($cat_id)->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-',$request->name)),
        ]);

            $notification = array(
                'message' => 'Sub Category Update Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('subcategory')->with($notification);

        }
    }


    public function delete($id){

        $category = SubCategory::findOrFail($id);
        $img = $category->image;
        unlink($img );

        SubCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Sub Category Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    // Category to Subcategory Lode in Javascript Ajax --------------------------------------------------

    public function getSubCategory($category_id){
        $subCat = SubCategory::where('category_id',$category_id)->orderBy('name','ASC')->get();
            return json_encode($subCat);

    }
}
