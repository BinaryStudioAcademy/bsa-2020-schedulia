<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use App\Notifications\Chatito\EventCreatedChatitoMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventCreatedNotificationToOwnerChatito extends Notification implements ShouldQueue
{
    use Queueable;

    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->toChatito();
    }

    private function toChatito()
    {
        return new EventCreatedChatitoMessage($this->event);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
