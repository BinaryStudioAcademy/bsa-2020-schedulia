<?php

namespace App\Exceptions;

use Exception;

class EmailIsNotVerifiedException extends BaseException
{
    protected $message = 'Email is not verified';
    protected $code = ErrorCode::EMAIL_IS_NOT_VERIFIED_EXCEPTION;
}
