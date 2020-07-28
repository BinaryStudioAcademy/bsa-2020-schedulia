<?php

declare(strict_types=1);

namespace App\Exceptions;

use DomainException;
use Throwable;

abstract class BaseException extends DomainException
{
    public function __construct(
        string $message = 'An unknown domain exception has been occurred.',
        int $code = ErrorCode::UNKNOWN_EXCEPTION,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
