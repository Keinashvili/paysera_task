<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ){}

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            $this->productRepository->getAll()
        );
    }

    public function show($id): ProductResource
    {
        return ProductResource::make(
            $this->productRepository->findById($id)
        );
    }
}
