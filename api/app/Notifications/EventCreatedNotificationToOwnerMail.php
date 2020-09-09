<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\EventCreatedMailToOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventCreatedNotificationToOwnerMail extends Notification implements ShouldQueue
{
    use Queueable;

    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new EventCreatedMailToOwner($this->event);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
