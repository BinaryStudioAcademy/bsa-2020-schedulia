<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class EndTimeBeforeStartTimeException extends BaseException
{
    protected $code = ErrorCode::END_TIME_BEFORE_START_TIME_EXCEPTION;
    protected $message = "Your end time cannot be before your start time!";
}
