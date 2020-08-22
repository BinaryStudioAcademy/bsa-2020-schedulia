<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class UnknownAvailabilityTypeException extends BaseException
{
    protected $message = "Unknown Availability type!";
    protected $code = ErrorCode::UNKNOWN_AVAILABILITY_TYPE;
}
