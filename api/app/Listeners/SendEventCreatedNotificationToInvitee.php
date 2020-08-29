<?php

namespace App\Listeners;

use App\Entity\User;
use App\Events\EventCreated;
use App\Mail\EventCreatedMailToInvitee;
use App\Mail\EventCreatedMailToOwner;
use App\Notifications\EventCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendEventCreatedNotificationToInvitee
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
        Mail::to($eventCreated->event->invitee_email)->send(
            new EventCreatedMailToInvitee($eventCreated->event)
        );
    }
}
