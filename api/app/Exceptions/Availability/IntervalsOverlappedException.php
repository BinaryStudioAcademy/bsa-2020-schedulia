<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;
use Throwable;

final class IntervalsOverlappedException extends BaseException
{
    private const INTERVALS_OVERLAPPED_MESSAGE = "Intervals are overlapping!";

    public function __construct(
        $message = self::INTERVALS_OVERLAPPED_MESSAGE,
        $code = ErrorCode::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
