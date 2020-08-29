<?php

namespace App\Mail;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventCreatedMailToInvitee extends Mailable
{
    use Queueable, SerializesModels;

    private Event $event;
    private EventType $eventType;
    private User $owner;
    private string $inviteeName;
    private string $inviteeEmail;
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
        $this->inviteeName = $event->invitee_name;
        $this->inviteeEmail = $event->invitee_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("You have been invited to an event: {$this->eventType->name},
                    {$this->event->start_date}, {$this->owner->name}")
            ->markdown('emails.event_created_to_invitee', [
                'event' => $this->event,
                'eventType' => $this->eventType,
                'owner' => $this->owner,
                'inviteeName' => $this->inviteeName,
                'inviteeEmail' => $this->inviteeEmail
            ]);
    }
}
