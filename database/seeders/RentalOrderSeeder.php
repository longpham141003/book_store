<?php

namespace Database\Seeders;

use App\Models\RentalOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class RentalOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); // Lấy người dùng đầu tiên

        RentalOrder::create([
            'user_id' => $user->id,
            'order_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'pending'
        ]);
    }
}
