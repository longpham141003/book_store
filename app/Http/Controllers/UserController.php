<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequests\StoreUserRequest;
use App\Http\Requests\BookRequests\UpdateUserRequest;
use App\Repositories\Interface\UserRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(): JsonResponse
    {
        try {
            $users = $this->userRepo->all();
            return response()->json($users);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy danh sách người dùng',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepo->create($request->validated());
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể tạo người dùng',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        try {
            $user = $this->userRepo->update($request->validated(), $id);
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể cập nhật người dùng',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->userRepo->delete($id);

            if (!$deleted) {
                return response()->json([
                    'error' => 'Người dùng không tồn tại',
                ], 404);
            }

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể xóa người dùng',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
