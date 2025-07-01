<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('manage categories');
        $category = $this->service->create($request->validated());
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('manage categories');
        $category = $this->service->update($category, $request->validated());
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('manage categories');
        $this->service->delete($category);
        return response()->json(null, 204);
    }
}
