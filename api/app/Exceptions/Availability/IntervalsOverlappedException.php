<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class IntervalsOverlappedException extends BaseException
{
    protected $message = "Intervals are overlapping!";
    protected $code = ErrorCode::INTERVALS_OVERLAPPED_EXCEPTION;
}
