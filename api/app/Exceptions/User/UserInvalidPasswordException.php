<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class UserInvalidPasswordException extends BaseException
{
    protected $message = 'Invalid old password has been provided.';
    protected $code = ErrorCode::INVALID_PASSWORD_EXCEPTION;
}
