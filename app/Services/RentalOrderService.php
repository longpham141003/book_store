<?php

namespace App\Services;

use App\Repositories\Interface\BookRepository;
use App\Repositories\Interface\RentalOrderRepository;
use App\Repositories\Interface\RentalOrderDetailRepository;
use Illuminate\Support\Facades\DB;

class RentalOrderService
{
    protected RentalOrderRepository $rentalOrderRepo;
    protected RentalOrderDetailRepository $rentalOrderDetailRepo;
    protected BookRepository $bookRepo;

    public function __construct(
        RentalOrderRepository $rentalOrderRepo,
        RentalOrderDetailRepository $rentalOrderDetailRepo,
        BookRepository $bookRepo
    ) {
        $this->rentalOrderRepo = $rentalOrderRepo;
        $this->rentalOrderDetailRepo = $rentalOrderDetailRepo;
        $this->bookRepo = $bookRepo;
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $orderData = [
                'user_id' => $data['user_id'],
//                'order_date' => now(),
                'order_date' => $data['order_date'],
                'due_date' => $data['due_date'],
                'status' => $data['status'] ?? 'pending',
            ];

            // Tạo đơn hàng
            $order = $this->rentalOrderRepo->create($orderData);

            foreach ($data['books'] as $book) {
                $bookModel = $this->bookRepo->find($book['book_id']);

                if ($bookModel->stock < $book['quantity']) {
                    return response()->json([
                        'message' => "Sách '{$bookModel->title}' không đủ số lượng!",
                        'stock' => $bookModel->stock
                    ], 400);
                }

                $bookModel->update(['stock' => $bookModel->stock - $book['quantity']]);

                $this->rentalOrderDetailRepo->create([
                    'rental_order_id' => $order->id,
                    'book_id' => $book['book_id'],
                    'quantity' => $book['quantity'],
                    'rental_price' => 10000,
                    'deposit_amount' => 50000,
                    'deposit_kept' => 0,
                ]);
            }

            return $order;
        });
    }


    public function updateOrder(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            // Cập nhật thông tin đơn hàng
            $order = $this->rentalOrderRepo->update([
                'due_date' => $data['due_date'],
                'status' => $data['status'] ?? 'pending',
            ], $id);

            foreach ($data['books'] as $book) {
                // Lấy thông tin chi tiết đơn hàng cũ
                $existingDetail = $this->rentalOrderDetailRepo->findBy([
                    'rental_order_id' => $id,
                    'book_id' => $book['book_id']
                ]);

                $bookModel = $this->bookRepo->find($book['book_id']);

                if ($existingDetail) {
                    $oldQuantity = $existingDetail->quantity;
                    $newQuantity = $book['quantity'];

                    if ($newQuantity > $oldQuantity) {
                        $diff = $newQuantity - $oldQuantity;
                        if ($bookModel->stock < $diff) {
                            return response()->json([
                                'message' => "Sách '{$bookModel->title}' không đủ số lượng!",
                                'stock' => $bookModel->stock
                            ], 400);
                        }
                        $bookModel->update(['stock' => $bookModel->stock - $diff]);
                    } elseif ($newQuantity < $oldQuantity) {
                        $diff = $oldQuantity - $newQuantity;
                        $bookModel->update(['stock' => $bookModel->stock + $diff]);
                    }
                } else {
                    if ($bookModel->stock < $book['quantity']) {
                        return response()->json([
                            'message' => "Sách '{$bookModel->title}' không đủ số lượng!",
                            'stock' => $bookModel->stock
                        ], 400);
                    }
                    $bookModel->update(['stock' => $bookModel->stock - $book['quantity']]);
                }

                // Cập nhật hoặc tạo mới chi tiết đơn hàng
                $this->rentalOrderDetailRepo->updateOrCreate(
                    ['rental_order_id' => $id, 'book_id' => $book['book_id']],
                    ['quantity' => $book['quantity']]
                );
            }

            return $order;
        });
    }


}
