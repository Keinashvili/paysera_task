<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\CartQuantityRequest;
use App\Http\Requests\StoreCartRequest;
use App\Models\CartProduct;
use App\Repositories\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;

readonly class CartService
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ) {
    }

    public function store(StoreCartRequest $request): void
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();

            $cartProduct = CartProduct::where('product_id', $request->product_id)
                ->first();

            if ($cartProduct) {
                $cartProduct->update([
                    'quantity' => $cartProduct->quantity + 1,
                ]);

                return;
            }

            CartProduct::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'cart_id' => $user->cart->id,
                'quantity' => 1,
            ]);
        });
    }

    public function updateQuantity($productId, CartQuantityRequest $request): void
    {
        $cartProduct = $this->cartRepository->getById($productId);

        $cartProduct->update([
            'quantity' => $request->quantity,
        ]);
    }

    public function delete($id): void
    {
        $cartProduct = $this->cartRepository->getById($id);

        $cartProduct->delete();
    }
}
