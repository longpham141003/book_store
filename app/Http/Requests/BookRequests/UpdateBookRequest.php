<?php

namespace App\Http\Requests\BookRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'rental_price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer',
            'status' => 'sometimes|in:available,rented,lost,damaged',
        ];
    }
}
