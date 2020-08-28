<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class WeekendException extends BaseException
{
    protected $message = "You can't book time at weekend";
    protected $code = ErrorCode::WEEKEND_EXCEPTION;
}
