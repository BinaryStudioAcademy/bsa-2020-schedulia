<?php

declare(strict_types=1);

namespace App\Exceptions;

final class GoogleOauthException extends BaseException
{
    protected $message = 'Can\'t authorize try again later';
    protected $code = ErrorCode::GOOGLE_OAUTH_EXCEPTION;
}
