<?php

declare(strict_types=1);

namespace App\Notifications\SlackMessages;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Queue\SerializesModels;

class EventCreatedSlackMessage extends SlackMessage
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $eventType = $event->eventType;
        $owner = $event->eventType->owner;

        $greetings = "Hi, {$owner->name}" . PHP_EOL . "A new event was scheduled.";

        return $this
            ->success()
            ->to($owner->slack_channel)
            ->content($greetings)
            ->attachment(function ($attachment) use ($event, $eventType) {
                $attachment->fields([
                    'Event Type' => $eventType->name,
                    'Invitee Name' => $event->invitee_name,
                    'Invitee Email' => $event->invitee_email,
                    'Event DateTime' => $event->start_date . ' (UTC)',
                    'Invitee Timezone' => $event->timezone,
                ]);
            });
    }
}
