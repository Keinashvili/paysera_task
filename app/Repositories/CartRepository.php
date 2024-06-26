<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getUserCart(): Collection|array
    {
        $cartId = auth()->user()->cart->id;

        return CartProduct::with('product')
            ->where('cart_id', $cartId)
            ->get();
    }

    public function getById($id)
    {
        $cartId = auth()->user()->cart->id;

        return CartProduct::where('cart_id', $cartId)
            ->findOrFail($id);
    }
}
