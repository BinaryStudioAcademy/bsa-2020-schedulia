<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Jobs\SendNotificationToOwnerChatito;
use App\Notifications\EventCreatedNotificationToOwnerChatito;
use App\Notifications\EventCreatedNotificationToOwnerMail;
use App\Notifications\EventCreatedNotificationToOwnerSlack;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEventCreatedNotificationToOwner implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(EventCreated $eventCreated)
    {
        $eventCreated->event->eventType->owner->notify(new EventCreatedNotificationToOwnerMail($eventCreated->event));
        if ($eventCreated->event->eventType->owner->slack_active) {
            $eventCreated->event->eventType->owner->notify(new EventCreatedNotificationToOwnerSlack($eventCreated->event));
        }
        if ($eventCreated->event->eventType->owner->chatito_active) {
            SendNotificationToOwnerChatito::dispatch($eventCreated->event);
        }
    }
}
