<?php

namespace App\Jobs;

use App\Notifications\NotificationBeforeEventForInvitee;
use App\Notifications\NotificationBeforeEventForOwner;
use App\Repositories\Event\Criterion\EventsAfterDateTimeCriterion;
use App\Repositories\Event\Criterion\EventsBeforeDateTimeCriterion;
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

    public function handle(EventRepository $eventRepository)
    {
        $now = CarbonImmutable::now();
        $tenMinutesLater = $now->addMinutes(10);
        $criteria = [
            new EventsAfterDateTimeCriterion($now->toDateTimeString()),
            new EventsBeforeDateTimeCriterion($tenMinutesLater->toDateTimeString()),
            new NotifiedCriterion(false)
           ];
        $events = $eventRepository->findByCriteria(...$criteria);

        foreach ($events as $event) {
            $event->eventType->owner->notify(new NotificationBeforeEventForOwner($event));
            Notification::route('mail', $event->invitee_email)
                ->notify(new NotificationBeforeEventForInvitee($event));
            $event->notified = true;
            $eventRepository->save($event);
        }
    }
}
