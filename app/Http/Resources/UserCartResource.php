<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $product = $this->product;

        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'product_description' => $product->description,
        ];
    }
}
