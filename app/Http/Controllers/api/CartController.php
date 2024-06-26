<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{CartQuantityRequest, StoreCartRequest};
use App\Http\Resources\UserCartResource;
use App\Repositories\CartRepositoryInterface;
use App\Services\CartService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ){}

    public function index(CartRepositoryInterface $cartRepository): AnonymousResourceCollection
    {
        return UserCartResource::collection(
            $cartRepository->getUserCart()
        );
    }

    public function store(StoreCartRequest $request)
    {
        return $this->cartService->store($request);
    }

    public function changeQuantity($id, CartQuantityRequest $request):  Response
    {
        return $this->cartService->updateQuantity(
            $id,
            $request->quantity,
        );
    }

    public function destroy($id): Response
    {
        return $this->cartService->delete($id);
    }
}
