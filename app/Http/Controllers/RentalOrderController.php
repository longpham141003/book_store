<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalOrderRequest;
use App\Http\Resources\RentalOrderResource;
use App\Repositories\Interface\RentalOrderRepository;
use App\Services\RentalOrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class RentalOrderController extends Controller
{
    protected RentalOrderService $rentalOrderService;
    protected RentalOrderRepository $rentalOrderRepo;

    public function __construct(RentalOrderService $rentalOrderService, RentalOrderRepository $rentalOrderRepo)
    {
        $this->rentalOrderService = $rentalOrderService;
        $this->rentalOrderRepo = $rentalOrderRepo;
    }

    public function index(): JsonResponse
    {
        try {
            $orders = $this->rentalOrderRepo->with(['user', 'rentalOrderDetails.book'])->all();
            return RentalOrderResource::collection($orders);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy danh sách đơn thuê',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(RentalOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->rentalOrderService->createOrder($request->validated());
            return response()->json(['order' => $order], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể tạo đơn thuê',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(RentalOrderRequest $request, $id): JsonResponse
    {
        try {
            $order = $this->rentalOrderService->updateOrder($id, $request->validated());
            return response()->json($order);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Đơn thuê không tồn tại',
                'message' => 'Không tìm thấy đơn thuê với ID đã chỉ định.',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu đầu vào không hợp lệ',
                'message' => $e->getMessage(),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể cập nhật đơn thuê',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->rentalOrderRepo->delete($id);

            if (!$deleted) {
                return response()->json([
                    'error' => 'Đơn thuê không tồn tại',
                ], 404);
            }

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể xóa đơn thuê',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOrdersByDate($date): JsonResponse
    {
        try {
            $orders = $this->rentalOrderRepo->getOrdersByDate($date);

            return response()->json([
                'date' => $date,
                'total_orders' => count($orders),
                'orders' => RentalOrderResource::collection($orders),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy đơn thuê theo ngày',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOverdueOrders(): JsonResponse
    {
        try {
            $today = now()->toDateString();
            $overdueOrders = $this->rentalOrderRepo->getOverdueOrders($today);

            return response()->json([
                'total_overdue' => $overdueOrders->count(),
                'overdue_orders' => RentalOrderResource::collection($overdueOrders),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Không thể lấy đơn thuê quá hạn',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
