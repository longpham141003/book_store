<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_date' => $this->order_date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'address' => $this->user->address,
            ],
            'books' => $this->rentalOrderDetails->map(function ($detail) {
                return [
                    'title' => $detail->book->title,
                    'rental_price' => $detail->rental_price,
                    'quantity' => $detail->quantity,
                    'deposit' => $detail->deposit_amount,
                ];
            }),
        ];
    }
}
