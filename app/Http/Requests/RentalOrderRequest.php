<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after:order_date',
//            'due_date' => 'required|date|after:today',
            'status' => 'nullable|in:pending,completed,overdue',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ];
    }
}
