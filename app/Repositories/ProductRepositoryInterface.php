<?php

declare(strict_types=1);

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAll();
    public function findById($id);
}
