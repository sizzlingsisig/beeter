<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {

            $this->middleware('admin')->only(['store', 'update', 'destroy']);

    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->store($request->validated());
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $updated = $this->service->update($category, $request->validated());
        return new CategoryResource($updated);
    }

   public function destroy(DestroyCategoryRequest $request, Category $category)
{
    $this->service->destroy($category);
    return response()->json(['message' => 'Category deleted.']);
}


}
