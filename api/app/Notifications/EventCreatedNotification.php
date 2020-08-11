<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EventCreatedNotification extends Notification
{
    use Queueable;

    private Event $event;
    private EventType $eventType;
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     */
    public function __construct(Event  $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->user = $event->eventType->owner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("New Event: {$this->event->invitee_name},
                    {$this->event->start_date}, {$this->eventType->name}")
                    ->line("Hi {$this->user->name},")
                    ->line("A new event was scheduled.")
                    ->line(new HtmlString("<b>Event Type:</b>"))
                    ->line($this->eventType->name)
                    ->line(new HtmlString("<b>Invitee:</b>"))
                    ->line($this->event->invitee_name)
                    ->line(new HtmlString("<b>Invitee Email:</b>"))
                    ->line($this->event->invitee_email)
                    ->line(new HtmlString("<b>Event Date/Time::</b>"))
                    ->line($this->event->start_date .', '. $this->event->timezone)
                    ->line(new HtmlString("<b>Invitee TimeZone:</b>"))
                    ->line($this->event->timezon)
                    ->action('Go to Schedulia!', url('http://localhost:8085'));
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
