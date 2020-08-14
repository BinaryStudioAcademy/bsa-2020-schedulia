<?php

declare(strict_types=1);

namespace App\Actions\Status\Event;

use Illuminate\Support\Collection;

class EventRequest
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
