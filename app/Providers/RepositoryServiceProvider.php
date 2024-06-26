<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\{CartRepository, CartRepositoryInterface, ProductRepository, ProductRepositoryInterface};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class,
        );

        $this->app->singleton(
            CartRepositoryInterface::class,
            CartRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
