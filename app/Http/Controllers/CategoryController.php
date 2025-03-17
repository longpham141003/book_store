<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequests\StoreCategoryRequest;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interface\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryRepo->all();
            return response()->json($categories);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy danh sách danh mục',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryRepo->create($request->validated());
            return response()->json($category, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể tạo danh mục',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(StoreCategoryRequest $request, $id): JsonResponse
    {
        try {
            $category = $this->categoryRepo->update($request->validated(), $id);

            if (!$category) {
                return response()->json([
                    'error' => 'Danh mục không tồn tại'
                ], 404);
            }

            return response()->json($category);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Danh mục không tìm thấy',
                'message' => 'Không tìm thấy danh mục với ID đã chỉ định.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể cập nhật danh mục',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->categoryRepo->delete($id);

            if (!$deleted) {
                return response()->json([
                    'error' => 'Danh mục không tồn tại'
                ], 404);
            }

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể xóa danh mục',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
