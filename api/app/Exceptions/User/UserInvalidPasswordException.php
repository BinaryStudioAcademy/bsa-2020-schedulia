<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use App\Exceptions\BaseException;
use Throwable;

final class UserInvalidPasswordException extends BaseException
{
    public function __construct($message = "Invalid old password has been provided", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
