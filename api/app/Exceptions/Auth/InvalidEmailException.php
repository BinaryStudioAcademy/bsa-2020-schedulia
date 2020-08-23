<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidEmailException extends Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
