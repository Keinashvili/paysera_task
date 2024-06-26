<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use Illuminate\Http\Response;
use Exception;

class CheckoutController
{
    /**
     * @throws Exception
     */
    public function __invoke(CheckoutRequest $request, CheckoutService $checkoutService): Response
    {
        $checkoutService->process($request);

        return response()->noContent();
    }
}
