<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::query();

        if ($request->search) {
            $categories = $categories->where('name', 'LIKE', "%{$request->search}%");
        }

        $categories = $categories->latest()->paginate(8);

        return Inertia::render('Category/Index', ['categories' => $categories]);
    }


    public function create()
    {
        return Inertia::render('Category/Create');
    }


    public function store(Request $request)
    {
        $input =  $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'description' => 'required|min:2',
        ]);

        $image = $request->file('image');
        $name_gen = time() . '.' . $image->getClientOriginalExtension();
        $save_url = 'images/categories/' . $name_gen;
        $image->move(public_path('images/categories'), $name_gen);
        $input['image'] = $save_url;
        $input['slug'] = strtolower(str_replace(' ', '-', $request->name));

        Category::create($input);

        return to_route('category.index');
    }


    public function edit($id)
    {

        $category = Category::findOrFail($id);

        return Inertia::render('Category/Edit', ['category' => $category]);
    }


    public function update(Request $request, $id)
    {
        $inputs = $request->validate([
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ]);

        $category = Category::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            if ($category && file_exists($category->image)) {
                unlink($category->image);
            }
            $image = $request->file('image');
            $name_gen = time() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/categories/' . $name_gen;
            $image->move(public_path('images/categories'), $name_gen);
            $inputs['image'] = $save_url;
        }

        $category->update($inputs);

        return to_route('category.index');
    }


    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if (file_exists($category->image)) {
            unlink($category->image);
        }
        $category->delete();

        return redirect()->route('category.index');
    }
}
