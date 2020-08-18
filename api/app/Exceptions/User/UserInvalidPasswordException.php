<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class UserInvalidPasswordException extends ModelNotFoundException
{
    public function __construct($message = "Invalid old password has been provided", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
