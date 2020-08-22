<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class AvailabilityValidationException extends BaseException
{
    protected $code = ErrorCode::AVAILABILITY_VALIDATION_EXCEPTION;
    protected $message;

    public function __construct($message = "")
    {
        $this->message = $message;
    }
}
