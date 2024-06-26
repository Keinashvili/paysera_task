<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UnauthorizedUserException extends Exception
{
    public function context(): array
    {
        return [
            'message' => 'User is unauthorized',
        ];
    }
}
