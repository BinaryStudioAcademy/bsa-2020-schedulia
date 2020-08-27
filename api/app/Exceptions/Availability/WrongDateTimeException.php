<?php

declare(strict_types=1);

namespace App\Exceptions\Availability;

use App\Exceptions\BaseException;
use App\Exceptions\ErrorCode;

final class WrongDateTimeException extends BaseException
{
    protected $message = 'Wrong date time data!';
    protected $code = ErrorCode::WRONG_DATE_TIME_EXCEPTION;
}
