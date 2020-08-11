<?php

declare(strict_types=1);

namespace App\Exceptions\Profile;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class ProfileNotFoundException extends ModelNotFoundException
{
    public function __construct($message = "Profile not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
