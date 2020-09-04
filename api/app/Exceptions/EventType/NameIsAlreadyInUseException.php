<?php

declare(strict_types=1);

namespace App\Exceptions\EventType;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class NameIsAlreadyInUseException extends BaseException
{
    protected $message = 'EventType with such name is already in use!';
    protected $code = ErrorCode::EVENT_TYPE_NAME_IS_ALREADY_IN_USE;
}
