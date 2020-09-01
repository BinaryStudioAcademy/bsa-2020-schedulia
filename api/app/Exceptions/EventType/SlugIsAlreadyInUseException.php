<?php

declare(strict_types=1);

namespace App\Exceptions\EventType;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class SlugIsAlreadyInUseException extends BaseException
{
    protected $message = 'EventType with such slug is already in use!';
    protected $code = ErrorCode::EVENT_TYPE_SLUG_IS_ALREADY_IN_USE;
}
