<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventTypeDeletedToInvitee extends Mailable
{
    use Queueable, SerializesModels;

    private string $startDate;
    private string $inviteeName;
    private string $eventTypeName;

    public function __construct(array $eventData)
    {
        $this->startDate = $eventData['start_date'];
        $this->inviteeName = $eventData['invitee_name'];
        $this->eventTypeName = $eventData['event_type_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Event declined!")
            ->markdown('emails.event_type_delete_to_invitee', [
                'inviteeName' => $this->inviteeName,
                'eventTypeName' => $this->eventTypeName,
                'startDate' => $this->startDate
            ]);
    }
}
