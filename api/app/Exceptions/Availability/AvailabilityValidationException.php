<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;
use Throwable;

final class AvailabilityValidationException extends BaseException
{
    public function __construct($message = "", $code = ErrorCode::BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
