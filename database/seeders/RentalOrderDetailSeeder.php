<?php

namespace Database\Seeders;

use App\Models\RentalOrderDetail;
use App\Models\RentalOrder;
use App\Models\Book;
use Illuminate\Database\Seeder;

class RentalOrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = RentalOrder::first(); 
        $book = Book::first(); 

        RentalOrderDetail::create([
            'rental_order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'rental_price' => $book->price,
            'deposit_amount' => 5000,
            'deposit_kept' => 0
        ]);
    }
}
