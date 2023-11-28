<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\V1\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->get();

        return apiResourceResponse(CategoryResource::collection($categories));
    }

    public function subCategories(Category $category)
    {
        $category->load('subcategories');

        return apiResourceResponse(CategoryResource::make($category));
    }
}
