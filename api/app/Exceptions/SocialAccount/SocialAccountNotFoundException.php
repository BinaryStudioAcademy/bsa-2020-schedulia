<?php

declare(strict_types=1);

namespace App\Exceptions\SocialAccount;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class SocialAccountNotFoundException extends ModelNotFoundException
{
    public function __construct($message = "Social account not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
