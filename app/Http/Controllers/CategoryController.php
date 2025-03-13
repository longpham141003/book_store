<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequests\StoreCategoryRequest;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interface\CategoryRepository;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepo;

    public function __construct(\App\Repositories\Interface\CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index() : JsonResponse
    {
        $categories = $this->categoryRepo->all();
        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepo->create($request->validated());
        return response()->json($category, 201);
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category = $this->categoryRepo->update($request->validated(), $id);
        return response()->json($category);
    }

    public function destroy($id)
    {
        $this->categoryRepo->delete($id);
        return response()->json(null, 204);
    }
}
