<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\auth;

use App\Exceptions\UnauthorizedUserException;
use App\Services\AuthService;
use Illuminate\Http\{Request, Response};

class LogoutController
{
    /**
     * @throws UnauthorizedUserException
     */
    public function __invoke(Request $request, AuthService $authService): Response
    {
        return $authService->logout($request);
    }
}
