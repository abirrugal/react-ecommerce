<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query();

        if ($request->search) {
            $brands = $brands->where('name', 'LIKE', "%{$request->search}%");
        }
        $brands = $brands->latest()->paginate(15);

        return Inertia::render('Brand/Index', ['brands' => $brands]);
    }


    public function create()
    {
        return Inertia::render('Brand/Create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'image' => 'required|mimes:png,jpg,jpeg',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return Inertia::render('Brand/Create', ['errors' => $validator->errors()->toArray()]);
        }
        $inputs = $validator->validated();

        $image = $request->file('image');
        $name_gen = time() . '.' . $image->getClientOriginalExtension();
        $save_url = 'images/brand/' . $name_gen;
        $image->move(public_path('images/brand'), $name_gen);
        //Save image url and slug in array
        $inputs['image'] = $save_url;
        $inputs['slug'] = strtolower(str_replace(' ', '-', $request->name));
        Brand::create($inputs);

        return redirect()->route('brand.index');
    }


    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return Inertia::render('Brand/Edit', ['brand' => $brand]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return Inertia::render('Brand/Edit', ['errors' => $validator->errors()->toArray(), 'brand' => []]);
        }

        $inputs = $validator->validated();
        $brand = Brand::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            if ($brand && file_exists($brand->image)) {
                unlink($brand->image);
            }
            $image = $request->file('image');
            $name_gen = time() . '.' . $image->getClientOriginalExtension();
            $save_url = 'images/brand/' . $name_gen;
            $image->move(public_path('images/brand'), $name_gen);
            $inputs['image'] = $save_url;
        }

        Brand::findOrFail($id)->update($inputs);

        return redirect()->route('brand.index');
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $img = $brand->image;
        if (file_exists($img))
            unlink($img);
        Brand::findOrFail($id)->delete();

        return redirect()->route('brand.index');
    }
}
