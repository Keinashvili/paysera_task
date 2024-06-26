<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\auth;

use App\Exceptions\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * @throws LoginException
     */
    public function __invoke(LoginRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json([
            'token' => $authService->login($request)
        ]);
    }
}
