<?php

declare(strict_types=1);

namespace App\Repositories;

interface CartRepositoryInterface
{
    public function getUserCart();

    public function getById($id);
}
