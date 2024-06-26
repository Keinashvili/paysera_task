<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Exception;

class RegisterController extends Controller
{
    /**
     * @throws Exception
     */
    public function __invoke(RegisterRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json([
            'token' => $authService->register($request),
        ]);
    }
}
