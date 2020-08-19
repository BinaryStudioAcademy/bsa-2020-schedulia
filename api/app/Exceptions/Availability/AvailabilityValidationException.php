<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class AvailabilityValidationException extends HttpException
{
    public function __construct(int $statusCode = 400, string $message = null, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
