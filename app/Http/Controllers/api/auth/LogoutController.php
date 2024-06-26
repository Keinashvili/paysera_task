<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\auth;

use App\Services\AuthService;
use Illuminate\Http\{JsonResponse, Request};

class LogoutController
{
    public function __invoke(Request $request, AuthService $authService): JsonResponse
    {
        $authService->logout($request);

        return response()->json();
    }
}
