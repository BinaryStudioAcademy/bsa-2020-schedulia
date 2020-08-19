<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class IntervalsOverlappedException extends HttpException
{
    private const INTERVALS_OVERLAPPED_MESSAGE = "Intervals are overlapping!";

    public function __construct(int $statusCode = 400, string $message = self::INTERVALS_OVERLAPPED_MESSAGE, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
