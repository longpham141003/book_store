<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('order_date');
            $table->date('due_date');
            $table->enum('status', ['pending', 'completed', 'overdue']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rental_orders');
    }
};
