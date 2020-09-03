<?php

namespace App\Jobs;

use App\Actions\Zoom\CreateMeetingAction;
use App\Constants\EventStatus;
use App\Notifications\NotificationBeforeEventForInvitee;
use App\Notifications\NotificationBeforeEventForOwner;
use App\Repositories\Event\Criterion\EventsAfterDateTimeCriterion;
use App\Repositories\Event\Criterion\EventsBeforeDateTimeCriterion;
use App\Repositories\Event\Criterion\EventStatusCriterion;
use App\Repositories\Event\Criterion\NotifiedCriterion;
use App\Repositories\Event\EventRepository;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendNotificationBeforeEvent implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
    }

    public function handle(EventRepository $eventRepository, CreateMeetingAction $meetingAction)
    {
        $now = CarbonImmutable::now();
        $tenMinutesLater = $now->addMinutes(10);
        $criteria = [
            new EventsAfterDateTimeCriterion($now->toDateTimeString()),
            new EventsBeforeDateTimeCriterion($tenMinutesLater->toDateTimeString()),
            new NotifiedCriterion(false),
            new EventStatusCriterion([EventStatus::SCHEDULED])
           ];
        $events = $eventRepository->findByCriteria(...$criteria);

        foreach ($events as $event) {
            $event->eventType->owner->notify(new NotificationBeforeEventForOwner($event));
            $startMeetingUrl = $meetingAction->execute($event->startDate, $event->eventType->name);
            Notification::route('mail', $event->invitee_email)
                ->notify(new NotificationBeforeEventForInvitee($event, $startMeetingUrl));
            $event->notified = true;
            $eventRepository->save($event);
        }
    }
}
