<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\BeforeEventMailForInvitee;
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
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new BeforeEventMailForInvitee($this->event))->build();
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
