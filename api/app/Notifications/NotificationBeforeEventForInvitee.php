<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\BeforeEventMailForInvitee;
use App\Notifications\Chatito\BeforeEventChatitoMessage;
use App\Notifications\Chatito\EventCreatedChatitoMessage;
use App\Notifications\SlackMessages\BeforeEventSlackMessageToOwner;
use App\Notifications\SlackMessages\EventCreatedSlackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationBeforeEventForInvitee extends Notification
{
    use Queueable;
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;

        if ($this->event->eventType->owner->chatito_active) {
            $this->toChatito();
        }
    }

    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new BeforeEventMailForInvitee($this->event))->build();
    }

    public function toSlack()
    {
        return new EventCreatedSlackMessage($this->event);
    }

    public function toChatito()
    {
        return new BeforeEventChatitoMessage($this->event);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
