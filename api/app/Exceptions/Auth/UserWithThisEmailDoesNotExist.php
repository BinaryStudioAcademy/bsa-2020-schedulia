<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;
use Throwable;

final class UserWithThisEmailDoesNotExist extends BaseException
{
    public function __construct($email = "", $code = 404, Throwable $previous = null)
    {
        $message = "User with email:{$email} does not exist";
        parent::__construct($message, $code, $previous);
    }
}
