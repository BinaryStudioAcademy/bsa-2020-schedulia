<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AccountVerificationException extends Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
