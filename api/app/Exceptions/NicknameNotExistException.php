<?php

declare(strict_types=1);

namespace App\Exceptions;

final class NicknameNotExistException extends BaseException
{
    protected $message = 'Nickname does not exist';
    protected $code = ErrorCode::NICKNAME_NOT_EXIST_EXCEPTION;
}
