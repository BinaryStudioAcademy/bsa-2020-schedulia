<?php

declare(strict_types=1);

namespace App\Notifications\Chatito;

final class EventCreatedChatitoMessage extends ChatitoMessage
{
    protected function generateMessage()
    {
        return "Hi, <b>{$this->event->invitee_name}</b> and <b>{$this->user->name}</b><br>" .
            "A new event was scheduled!<br><br>" .
            "<b>Event Type:</b><br>" .
            "{$this->eventType->name}<br><br>" .
            "<b>Invitee Name:</b><br>" .
            "{$this->event->invitee_name}<br><br>" .
            "<b>Invitee Email:</b><br>" .
            "{$this->event->invitee_email}<br><br>" .
            "<b>Invitee Timezone::</b><br>" .
            "{$this->event->timezone}<br><br>" .
            "<b>Organizator Name:</b><br>" .
            "{$this->user->name}<br><br>" .
            "<b>Organizator Email:</b><br>" .
            "{$this->user->email}<br><br>" .
            "<b>Event Date/Time:</b><br>" .
            "{$this->event->start_date}<br>";
    }
}
