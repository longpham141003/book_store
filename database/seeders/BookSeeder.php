<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::first(); 

        Book::create([
            'title' => 'Sách 1',
            'author' => 'Tác giả 1',
            'price' => 20000,
            'stock' => 10,
            'category_id' => $category->id,
            'status' => 'available'
        ]);

        Book::create([
            'title' => 'Sách 2',
            'author' => 'Tác giả 2',
            'price' => 25000,
            'stock' => 5,
            'category_id' => $category->id,
            'status' => 'available'
        ]);
    }
}
