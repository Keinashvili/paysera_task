<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\AuthService;
use Illuminate\Http\{Request, Response};

class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function update(UpdateUserRequest $request, AuthService $authService): Response
    {
        return $authService->update($request);
    }
}
