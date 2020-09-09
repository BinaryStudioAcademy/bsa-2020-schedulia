<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Notifications\SlackMessages\EventCreatedSlackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventCreatedNotificationToOwnerSlack extends Notification implements ShouldQueue
{
    use Queueable;

    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return new EventCreatedSlackMessage($this->event);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
