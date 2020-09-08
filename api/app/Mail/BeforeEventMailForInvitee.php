<?php

namespace App\Mail;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class BeforeEventMailForInvitee extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Event $event;
    public EventType $eventType;
    public User $owner;
    private string $inviteeName;
    private string $inviteeEmail;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->owner = $event->eventType->owner;
        $this->inviteeName = $event->invitee_name;
        $this->inviteeEmail = $event->invitee_email;
    }

    public function build()
    {
        $eventTimeInUTCZone = new Carbon($this->event->start_date);

        $message = (new MailMessage())
            ->subject(Lang::get('A reminder of an upcoming event from Schedulia'))
            ->line(Lang::get('We remind you that you have been invited to the event, the details of which are given below and it will start in 10 minutes.'))
            ->line(Lang::get('Type of event:'))
            ->line($this->eventType->name)
            ->line(Lang::get('Description of event:'))
            ->line($this->eventType->description)
            ->line(Lang::get('Owner of event:'))
            ->line($this->owner->getName())
            ->line(Lang::get('Event Date/Time in UTC timezone:'))
            ->line($this->event->start_date)
            ->line(Lang::get("Event Date/Time in {$this->event->timezone} timezone:"))
            ->line($eventTimeInUTCZone->timezone($this->event->timezone));

        if ($this->event->eventType->location_type == 'zoom') {
            $message = $message->line(Lang::get('Your Zoom meeting link'))
                ->line(new HtmlString('<a href="' . $this->event->zoom_meeting_link . '">' . "{$this->event->zoom_meeting_link}" . '</a>'));
        }

        if ($this->event->eventType->location_type == 'whale') {
            $message = $message->line(Lang::get('Your Whale meeting link'))
                ->line(new HtmlString('<a href="' . $this->event->whale_meeting_link . '">' . "{$this->event->whale_meeting_link}" . '</a>'));
        }

        return $message;
    }
}
