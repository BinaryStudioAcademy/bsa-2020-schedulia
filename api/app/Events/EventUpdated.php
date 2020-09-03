<?php

namespace App\Events;

use App\Entity\Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function broadcastAs(): string
    {
        return 'event.updated';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('events');
    }

    public function getEvent(): Event
    {
        return $this->event;
    }
}
