<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class UnknownAvailabilityTypeException extends HttpException
{
    private const UNKNOWN_AVAILABILITY_MESSAGE = "Unknown Availability type!";

    public function __construct(int $statusCode = 400, string $message = self::UNKNOWN_AVAILABILITY_MESSAGE, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
