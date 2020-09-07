<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\BeforeEventMailForOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationBeforeEventForOwner extends Notification
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
        return (new BeforeEventMailForOwner($this->event))->build();
    }
}
