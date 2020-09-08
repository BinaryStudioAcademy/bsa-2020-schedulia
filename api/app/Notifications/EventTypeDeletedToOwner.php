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

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail'];

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line(new HtmlString("Hi, <b>{$this->owner->name}</b>!"))
                    ->line(new HtmlString("EventType <u>{$this->eventTypeName}</u> was deleted, so all events was declined!"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
