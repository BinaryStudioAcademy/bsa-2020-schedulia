<?php

declare(strict_types=1);

namespace App\Exceptions\EventType;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class CoordinatesFieldIsRequiredException extends BaseException
{
    protected $message = "Please, choose address for your meeting";
    protected $code = ErrorCode::COORDINATES_FIELD_IS_REQUIRED;
}
