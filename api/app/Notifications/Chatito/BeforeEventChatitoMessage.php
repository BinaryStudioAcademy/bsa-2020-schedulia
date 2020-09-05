<?php

declare(strict_types=1);

namespace App\Notifications\Chatito;

class BeforeEventChatitoMessage extends ChatitoMessage
{
    protected function generateMessage()
    {
        return "Hi, {$this->event->invitee_name} and {$this->user->name}" . PHP_EOL .
            "An event <u>{$this->eventType->name}</u> will be start in 10 minutes" . PHP_EOL .
            "<b>Event Type:</b>" . PHP_EOL .
            "{$this->eventType->name}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Name:</b>" . PHP_EOL .
            "{$this->event->invitee_name}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Email:</b>" . PHP_EOL .
            "{$this->event->invitee_email}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Timezone:</b>" . PHP_EOL .
            "{$this->event->timezone}" . PHP_EOL . PHP_EOL .
            "<b>Organizator Name:</b>" . PHP_EOL .
            "{$this->user->name}" . PHP_EOL . PHP_EOL .
            "<b>Organizator Email:</b>" . PHP_EOL .
            "{$this->user->email}" . PHP_EOL . PHP_EOL .
            "<b>Event Date/Time:</b>" . PHP_EOL .
            "{$this->event->start_date}" . PHP_EOL;
    }
}
