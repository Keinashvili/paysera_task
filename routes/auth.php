<?php

declare(strict_types=1);

use App\Http\Controllers\api\auth\{LogoutController, RegisterController, LoginController, UserController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/register', [RegisterController::class, '__invoke']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::patch('/user', [UserController::class, 'update']);
    Route::post('/logout', [LogoutController::class, '__invoke']);
});
