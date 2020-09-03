<?php

declare(strict_types=1);

namespace App\Exceptions\EventType;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class CoordinatesFieldIsRequiredException extends BaseException
{
    protected $message = "For 'location_type = address' field 'coordinates' is required!";
    protected $code = ErrorCode::COORDINATES_FIELD_IS_REQUIRED;
}
