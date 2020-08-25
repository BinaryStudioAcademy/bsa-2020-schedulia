<?php

namespace App\Exceptions;

use Exception;

class UserAlreadyVerifiedException extends BaseException
{
    protected $message = 'User already verified!';
    protected $code = ErrorCode::USER_ALREADY_VERIFIED_EXCEPTION;
}
