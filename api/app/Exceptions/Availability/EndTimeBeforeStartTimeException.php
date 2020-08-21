<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;
use Throwable;

final class EndTimeBeforeStartTimeException extends BaseException
{
    private const END_TIME_BEFORE_START_TIME_MESSAGE = "Your end time cannot be before your start time!";

    public function __construct(
        $message = self::END_TIME_BEFORE_START_TIME_MESSAGE,
        $code = ErrorCode::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
