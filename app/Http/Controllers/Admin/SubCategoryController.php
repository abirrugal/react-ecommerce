<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {

        $subcategories = SubCategory::query();

        if ($request->search) {
            $subcategories = $subcategories->where('name', 'LIKE', "%{$request->search}%");
        }
        $subcategories = $subcategories->latest()->paginate(15);

        return Inertia::render('Subcategory/Index', ['subcategories' => $subcategories]);
    }

    public function create()
    {

        $categories = Category::orderBy('name', 'ASC')->get();

        return Inertia::render('Subcategory/Create', ['categories' => $categories]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        $image = $request->file('image');
        $name_gen = time() . '.' . $image->getClientOriginalExtension();
        $save_url = 'images/subcategory/' . $name_gen;
        $image->move(public_path('images/subcategory'), $name_gen);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'image' => $save_url,
        ]);

        return redirect()->route('subcategory.index');
    }


    public function edit($id)
    {

        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);

        return Inertia::render('Subcategory/Edit', ['categories' => $categories, 'subcategory' => $subcategory]);
    }


    public function update(Request $request, $id)
    {
        $inputs = $request->validate([
            'name' => 'required|min:2',
            'category_id' => 'required|numeric|exists:categories,id',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ]);

        $subCategory = SubCategory::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            if ($subCategory && file_exists($subCategory->image)) {
                unlink($subCategory->image);
            }
            $image = $request->file('image');
            $name_gen = time() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/subcategories/' . $name_gen;
            $image->move(public_path('images/subcategories'), $name_gen);
            $inputs['image'] = $save_url;
        }
        $subCategory->update($inputs);

        return to_route('subcategory.index');
    }

    public function delete($id)
    {

        $Subcategory = SubCategory::findOrFail($id);

        if (file_exists($Subcategory->image)) {
            unlink($Subcategory->image);
        }
        $Subcategory->delete();

        return redirect()->route('subcategory.index');
    }


    // Category to Subcategory Lode in Javascript Ajax --------------------------------------------------

    public function getSubCategory($category_id)
    {
        $subCat = SubCategory::where('category_id', $category_id)->orderBy('name', 'ASC')->get();
        return json_encode($subCat);
    }
}
