<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'category_id' => 'required|numeric|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $categories = Category::orderBy('name', 'ASC')->get();
            return Inertia::render('Subcategory/Create', ['errors' => $validator->errors()->toArray(), 'categories' => $categories]);
        }

        $input = $validator->validated();

        $image = $request->file('image');
        $name_gen = time() . '.' . $image->getClientOriginalExtension();
        $save_url = 'images/subcategory/' . $name_gen;
        $image->move(public_path('images/subcategory'), $name_gen);
        $input['image'] = $save_url;
        $input['slug'] = strtolower(str_replace(' ', '-', $request->name));

        SubCategory::create($input);

        return to_route('subcategory.index');
    }


    public function edit($id)
    {

        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);

        return Inertia::render('Subcategory/Edit', ['categories' => $categories, 'subcategory' => $subcategory]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'category_id' => 'required|numeric|exists:categories,id',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            return Inertia::render('Subcategory/Edit', ['errors' => $validator->errors()->toArray(), 'subcategory' => []]);
        }
        
        $inputs = $validator->validated();
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
