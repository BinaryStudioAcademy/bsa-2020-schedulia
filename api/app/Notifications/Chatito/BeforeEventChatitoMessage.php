<?php

declare(strict_types=1);

namespace App\Notifications\Chatito;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class BeforeEventChatitoMessage extends ChatitoMessage
{
    protected function generateMessage()
    {
        $message = "Hi, <b>{$this->event->invitee_name}</b> and <b>{$this->user->name}</b><br>" .
            "An event <u>{$this->eventType->name}</u> will be start in 10 minutes!<br><br>" .
            "<b>Event Type:</b><br>" .
            "{$this->eventType->name}<br><br>" .
            "<b>Invitee Name:</b><br>" .
            "{$this->event->invitee_name}<br><br>" .
            "<b>Invitee Email:</b><br>" .
            "{$this->event->invitee_email}<br><br>" .
            "<b>Invitee Timezone:</b><br>" .
            "{$this->event->timezone}<br><br>" .
            "<b>Organizator Name:</b><br>" .
            "{$this->user->name}<br><br>" .
            "<b>Organizator Email:</b><br>" .
            "{$this->user->email}<br><br>" .
            "<b>Event Date/Time (UTC):</b><br>" .
            "{$this->event->start_date}<br><br>";

        if ($this->event->eventType->location_type == 'zoom') {
            $message .= "<b>Your Zoom meeting link:</b><br>" .
                '<a href="' . $this->event->zoom_meeting_link . '">' . "{$this->event->zoom_meeting_link}" . '</a><br><br>';
        }

        if ($this->event->eventType->location_type == 'whale') {
            $message .= "<b>Your Whale meeting link:</b><br>" .
                '<a href="' . $this->event->whale_meeting_link . '">' . "{$this->event->whale_meeting_link}" . '</a><br><br>';
        }
        return $message;
    }
}
