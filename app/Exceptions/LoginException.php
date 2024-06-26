<?php

namespace App\Exceptions;

use Exception;

class LoginException extends Exception
{
    public function context(): array
    {
        return [
            'message' => 'These credentials do not match our records.'
        ];
    }
}
