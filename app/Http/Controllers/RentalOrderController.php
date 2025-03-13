<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalOrderRequest;
use App\Http\Resources\RentalOrderResource;
use App\Repositories\Interface\RentalOrderRepository;
use App\Services\RentalOrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalOrderController extends Controller
{
    protected RentalOrderService $rentalOrderService;
    protected RentalOrderRepository $rentalOrderRepo;

    public function __construct(RentalOrderService $rentalOrderService, RentalOrderRepository $rentalOrderRepo)
    {
        $this->rentalOrderService = $rentalOrderService;
        $this->rentalOrderRepo = $rentalOrderRepo;
    }

    public function index()
    {
        $orders = $this->rentalOrderRepo->with(['user', 'rentalOrderDetails.book'])->all();
        return RentalOrderResource::collection($orders);
    }

    public function store(RentalOrderRequest $request)
    {
        $order = $this->rentalOrderService->createOrder($request->validated());
        return response()->json(['order' => $order ], 201);
    }

    public function update(RentalOrderRequest $request, $id)
    {
        $order = $this->rentalOrderService->updateOrder($id, $request->validated());
        return response()->json($order);
    }

    public function destroy($id)
    {
        $this->rentalOrderRepo->delete($id);
        return response()->json(null, 204);
    }


    public function getOrdersByDate($date)
    {
        $orders = $this->rentalOrderRepo->getOrdersByDate($date);

        return response()->json([
            'date' => $date,
            'total_orders' => count($orders),
            'orders' => RentalOrderResource::collection($orders),
        ]);
    }


    public function getOverdueOrders()
    {
        $today = now()->toDateString();
        $overdueOrders = $this->rentalOrderRepo->getOverdueOrders($today);

        return response()->json([
            'total_overdue' => $overdueOrders->count(),
            'overdue_orders' => RentalOrderResource::collection($overdueOrders),
        ]);
    }

}
