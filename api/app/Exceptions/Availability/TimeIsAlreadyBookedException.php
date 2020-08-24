<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class TimeIsAlreadyBookedException extends BaseException
{
    protected $message = "Chosen time is already booked!";
    protected $code = ErrorCode::TIME_IS_ALREADY_BOOKED;
}
