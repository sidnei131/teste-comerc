<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
