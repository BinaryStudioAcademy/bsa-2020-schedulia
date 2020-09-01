<?php

namespace App\Mail;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventCreatedMailToOwner extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Event $event;
    public EventType $eventType;
    public User $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->owner = $event->eventType->owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->owner->getEmail());

        return $this
            ->subject("New Event: {$this->event->invitee_name},
                    {$this->event->start_date}, {$this->eventType->name}")
            ->markdown('notifications.event_created', [
            'event' => $this->event,
            'eventType' => $this->eventType,
            'user' => $this->owner
        ]);
    }
}
