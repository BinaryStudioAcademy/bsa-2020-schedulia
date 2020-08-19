<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class EndTimeBeforeStartTimeException extends HttpException
{
    private const END_TIME_BEFORE_START_TIME_MESSAGE = "Your end time cannot be before your start time!";

    public function __construct(int $statusCode = 400, string $message = self::END_TIME_BEFORE_START_TIME_MESSAGE, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
