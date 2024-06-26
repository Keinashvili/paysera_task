<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/./auth.php';

Route::middleware('auth:api')
    ->group(
        fn() => require_once __DIR__ . '/./products.php'
    );

Route::middleware('auth:api')
    ->group(
        fn() => require_once __DIR__ . '/./cart.php'
    );
