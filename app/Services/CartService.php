<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CartProduct;
use App\Repositories\CartRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

readonly class CartService
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ){}

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            $cartProduct = CartProduct::where('product_id', $request->product_id)
                ->first();

            if ($cartProduct) {
                $cartProduct->update([
                    'quantity' => $cartProduct->quantity + 1,
                ]);

                return response()->noContent(201);
            }

            CartProduct::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'cart_id' => $user->cart->id,
                'quantity' => 1,
            ]);

            return response()->noContent(201);
        });
    }

    public function updateQuantity($productId, $quantity): Response
    {
        $cartProduct = $this->cartRepository->getById($productId);

        $cartProduct->update([
            'quantity' => $quantity,
        ]);

        return response()->noContent();
    }

    public function delete($id): Response
    {
        $cartProduct = $this->cartRepository->getById($id);

        $cartProduct->delete();

        return response()->noContent(200);
    }
}
