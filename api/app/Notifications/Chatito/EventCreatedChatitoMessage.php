<?php

declare(strict_types=1);

namespace App\Notifications\Chatito;

final class EventCreatedChatitoMessage extends ChatitoMessage
{
    protected function generateMessage()
    {
        return "Hi, {$this->event->invitee_name} and {$this->user->name}" . PHP_EOL .
            "A new event was scheduled!" . PHP_EOL .
            "<b>Event Type:</b>" . PHP_EOL .
            "{$this->eventType->name}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Name:</b>" . PHP_EOL .
            "{$this->event->invitee_name}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Email:</b>" . PHP_EOL .
            "{$this->event->invitee_email}" . PHP_EOL . PHP_EOL .
            "<b>Invitee Timezone::</b>" . PHP_EOL .
            "{$this->event->timezone}" . PHP_EOL . PHP_EOL .
            "<b>Event Date/Time:</b>" . PHP_EOL .
            "{$this->event->start_date}" . PHP_EOL;
    }
}
