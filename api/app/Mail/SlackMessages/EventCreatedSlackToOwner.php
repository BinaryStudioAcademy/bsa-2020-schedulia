<?php

declare(strict_types=1);

namespace App\Mail\SlackMessages;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Queue\SerializesModels;

class EventCreatedSlackToOwner extends SlackMessage implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Event $event;
    public EventType $eventType;
    public User $owner;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->owner = $event->eventType->owner;
    }

    public function getMessage()
    {
        $event = $this->event;
        $eventType = $this->event->eventType;
        $greetings = "Hi, {$this->owner->name}" . PHP_EOL . "A new event was scheduled.";
        return (new SlackMessage())
            ->success()
            ->to($this->owner->slack_channel)
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
