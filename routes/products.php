<?php

declare(strict_types=1);

use App\Http\Controllers\api\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/product/{product}', 'show');
});

Route::post('checkout', [CheckoutController::class, '__invoke']);
