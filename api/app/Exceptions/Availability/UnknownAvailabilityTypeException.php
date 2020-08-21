<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;
use Throwable;

final class UnknownAvailabilityTypeException extends BaseException
{
    private const UNKNOWN_AVAILABILITY_MESSAGE = "Unknown Availability type!";

    public function __construct(
        $message = self::UNKNOWN_AVAILABILITY_MESSAGE,
        $code = ErrorCode::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
