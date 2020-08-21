<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ErrorCode
{
    public const UNKNOWN_EXCEPTION = 1000;
    public const EXAMPLE_EXCEPTION = 1001;
    public const INVALID_PASSWORD_EXCEPTION = 1002;
    public const INVALID_OR_EXPIRED_TOKEN = 1003;
    public const BAD_REQUEST = 400;
}
