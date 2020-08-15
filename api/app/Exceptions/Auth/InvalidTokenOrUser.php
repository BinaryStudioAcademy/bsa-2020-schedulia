<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Throwable;

final class InvalidTokenOrUser extends BaseException
{
    public function __construct($code = 400, Throwable $previous = null)
    {
        $message = "Token or email are invalid";
        parent::__construct($message, $code, $previous);
    }
}
