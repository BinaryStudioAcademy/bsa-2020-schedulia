<?php

namespace App\Jobs;

use App\Entity\User;
use App\Mail\EventTypeDeletedToInvitee;
use App\Notifications\EventTypeDeletedToOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationWhenEventTypeDeleted implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $eventType;
    private $owner;
    private $eventTypeEvents;

    public function __construct($eventType, User $owner, $eventTypeEvents)
    {
        $this->eventType = $eventType;
        $this->owner = $owner;
        $this->eventTypeEvents = $eventTypeEvents;
    }

    public function handle()
    {
        $this->owner->notify(new EventTypeDeletedToOwner($this->eventType, $this->owner));
        if (count($this->eventTypeEvents)) {
            foreach ($this->eventTypeEvents as $event) {
                Mail::to($event['invitee_email'])->send(
                    new EventTypeDeletedToInvitee($event)
                );
            }
        }
    }
}
