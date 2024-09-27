<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

Route::get('/', [ShopController::class, 'index']);
Route::post('/purchase', [ShopController::class, 'store']);
Route::get('/purchase/{id}', [ShopController::class, 'show'])->name('show');
Route::get('/orders', [ShopController::class, 'order'])->name('orders');
