<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['rental_order_id', 'book_id', 'quantity', 'rental_price', 'deposit_amount', 'deposit_kept'];

    public function rentalOrder()
    {
        return $this->belongsTo(RentalOrder::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
