<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequests\StoreBookRequest;
use App\Http\Requests\BookRequests\UpdateBookRequest;
use App\Repositories\Interface\BookRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    protected BookRepository $bookRepo;

    public function __construct(BookRepository $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function index(): JsonResponse
    {
        try {
            $books = $this->bookRepo->all();
            return response()->json($books);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy danh sách sách',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        try {
            $bookData = $request->validated();

            // Nếu có ảnh, lưu ảnh trước rồi lấy ID
            if ($request->hasFile('image')) {
                $image = $this->imageRepo->uploadImage($request->file('image'));
                $bookData['image_id'] = $image->id;
            }

            $book = $this->bookRepo->create($bookData);
            return response()->json($book, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể tạo sách',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateBookRequest $request, $id): JsonResponse
    {
        try {
            $book = $this->bookRepo->update($request->validated(), $id);

            if (!$book) {
                return response()->json([
                    'error' => 'Sách không tồn tại'
                ], 404);
            }

            return response()->json($book);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Sách không tìm thấy',
                'message' => 'Không tìm thấy sách với ID đã chỉ định.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể cập nhật sách',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->bookRepo->delete($id);

            if (!$deleted) {
                return response()->json([
                    'error' => 'Sách không tồn tại'
                ], 404);
            }

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể xóa sách',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
