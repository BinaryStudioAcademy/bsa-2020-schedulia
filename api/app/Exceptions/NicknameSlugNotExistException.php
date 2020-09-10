<?php

declare(strict_types=1);

namespace App\Exceptions;

final class NicknameSlugNotExistException extends BaseException
{
    protected $message = 'Combination nickname and slug does not exist';
    protected $code = ErrorCode::NICKNAME_SLUG_NOT_EXIST_EXCEPTION;
}
