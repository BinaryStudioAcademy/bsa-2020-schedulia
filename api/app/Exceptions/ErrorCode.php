<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ErrorCode
{
    public const UNKNOWN_EXCEPTION = 1000;
    public const EXAMPLE_EXCEPTION = 1001;
    public const INVALID_PASSWORD_EXCEPTION = 1002;
    public const INVALID_OR_EXPIRED_TOKEN = 1003;
    public const AVAILABILITY_VALIDATION_EXCEPTION = 1004;
    public const UNKNOWN_AVAILABILITY_TYPE = 1005;
    public const INTERVALS_OVERLAPPED_EXCEPTION = 1006;
    public const END_TIME_BEFORE_START_TIME_EXCEPTION = 1007;
    public const TIME_IS_ALREADY_BOOKED = 1008;
    public const WEEKEND_EXCEPTION = 1009;
    public const USER_ALREADY_VERIFIED_EXCEPTION = 1010;
    public const EMAIL_IS_NOT_VERIFIED_EXCEPTION = 1011;
    public const WRONG_DATE_TIME_EXCEPTION = 1012;
    public const EVENT_TYPE_NAME_IS_ALREADY_IN_USE = 1013;
    public const EVENT_TYPE_SLUG_IS_ALREADY_IN_USE = 1014;
}
