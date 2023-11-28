<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(){

        $categories = Category::query()->latest()->paginate(10);

        return Inertia::render('Category/Index', ['categories' => $categories]);
    }


    public function create(){

        // return view('admin.category.create');
        return Inertia::render('Category/Create');
    }


    public function store(Request $request){

        $image = $request->file('image');
        $name_gen = time().'.'.$image->getClientOriginalExtension();
        $save_url = 'images/categories/'.$name_gen;
        $image->move(public_path('images/categories'), $name_gen);

        Category::insert([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'description' => $request->description,
            'image' => $save_url,
        ]);

        // $notification = array(
        //     'message' => 'Category Add Successfully',
        //     'alert-type' => 'success'
        // );

        return to_route('category.index');
    }


    public function edit($id){

        $category = Category::findOrFail($id);

        return view('admin.category.edit',compact('category'));
    }


    public function update(Request $request){

        $cat_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().'.'.$image->getClientOriginalExtension();
            $save_url = 'images/categories/'.$name_gen;
            $image->move(public_path('images/categories'), $name_gen);

        if (file_exists($old_img)) {
           unlink($old_img);
        }

        Category::findOrFail($cat_id)->update([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-',$request->name)),
            'description' => $request->description,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category')->with($notification);
        } else {

             Category::findOrFail($cat_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-',$request->name)),
                'description' => $request->description,
        ]);

        $notification = array(
            'message' => 'Category Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category')->with($notification);
        }
    }


    public function delete($id){

        $category = Category::findOrFail($id);
        $img = $category->image;
        unlink($img );

        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Category Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category')->with($notification);
    }
}
