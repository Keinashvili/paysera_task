<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\{Builder, Collection, Model};

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function findById($id): Model|Collection|Builder|array|null
    {
        return Product::query()->findOrFail($id);
    }
}
