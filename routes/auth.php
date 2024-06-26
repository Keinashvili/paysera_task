<?php

declare(strict_types=1);

use App\Http\Controllers\api\auth\{LogoutController, RegisterController, LoginController, UserController};
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, '__invoke']);
Route::post('/register', [RegisterController::class, '__invoke']);

Route::middleware('auth:api')
    ->withoutMiddleware('guest')->group(function () {
        Route::get('/user', [UserController::class, 'user']);
        Route::patch('/update/user', [UserController::class, 'update']);
});
