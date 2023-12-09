<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $variants = Variant::query();
        if($request->search){
            $variants = $variants->where('name', 'LIKE', "%{$request->search}%");
        }
        $variants = $variants->latest()->paginate(15);

        return Inertia::render('Product/Attribute/Index', ['variants'=>$variants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Attribute/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validation = Validator::make($request->all(), [
         'name' => 'required|min:2',
         'status' => 'required'
       ]);

       if($validation->fails()){
        return Inertia::render('Product/Attribute/Create', ['errors'=>$validation->errors()->toArray()]);
       }

       $inputs = $request->all();
       Variant::create($inputs);

       return to_route('attribute.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $variant = Variant::find($id);
        return Inertia::render('Product/Attribute/Edit', ['variant' => $variant, 'errors'=>[]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'status' => 'required'
          ]);
   
          if($validation->fails()){
           return Inertia::render('Product/Attribute/Edit', ['errors'=>$validation->errors()->toArray()]);
          }

          $attribute = Variant::find($id);
          $attribute->update($validation->validated());
   
          return to_route('attribute.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
         Variant::find($id)->delete();

        return to_route('attribute.index');
    }
}
