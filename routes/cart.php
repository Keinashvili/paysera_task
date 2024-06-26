<?php

declare(strict_types=1);

use App\Http\Controllers\api\CartController;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index');
    Route::post('/cart', 'store');
    Route::patch('/cart_change_quantity/{id}', 'changeQuantity');
    Route::delete('/cart/{id}', 'destroy');
});
