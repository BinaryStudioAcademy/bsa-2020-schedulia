<?php

namespace App\Notifications;

use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EventTypeDeletedToOwner extends Notification implements ShouldQueue
{
    use Queueable;

    private $eventTypeName;
    private User $owner;

    public function __construct($eventTypeName, User $owner)
    {
        $this->eventTypeName = $eventTypeName;
        $this->owner = $owner;
    }

    public function via($notifiable)
    {
        $channels = ['mail'];

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->subject("EventType was deleted!")
                    ->line(new HtmlString("Hi, <b>{$this->owner->name}</b>!"))
                    ->line(new HtmlString("EventType <u>{$this->eventTypeName}</u> was deleted, so all events was declined!"));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
