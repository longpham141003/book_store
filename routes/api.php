<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Hello long dep trai']);
    });
    Route::apiResource('users', \App\Http\Controllers\UserController::class);
    Route::apiResource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::get('/rental-orders/by-date/{date}', [\App\Http\Controllers\RentalOrderController::class, 'getOrdersByDate']);
    Route::get('/rental-orders/overdue', [\App\Http\Controllers\RentalOrderController::class, 'getOverdueOrders']);
});

Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
//    Route::apiResource('.....', ....::class)->Only...
});
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class);
Route::apiResource('rental-orders', \App\Http\Controllers\RentalOrderController::class);





