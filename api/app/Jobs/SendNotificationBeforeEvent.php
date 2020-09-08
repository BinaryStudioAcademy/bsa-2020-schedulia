<?php

namespace App\Jobs;

use App\Constants\EventStatus;
use App\Entity\Event;
use App\Notifications\NotificationBeforeEventForInvitee;
use App\Notifications\NotificationBeforeEventForOwner;
use App\Repositories\Event\Criterion\EventsAfterDateTimeCriterion;
use App\Repositories\Event\Criterion\EventsBeforeDateTimeCriterion;
use App\Repositories\Event\Criterion\EventStatusCriterion;
use App\Repositories\Event\Criterion\NotifiedCriterion;
use App\Repositories\Event\EventRepository;
use App\Services\Whale\WhaleService;
use App\Services\Zoom\ZoomService;
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

    public function handle(
        EventRepository $eventRepository,
        ZoomService $zoomService,
        WhaleService $whaleService
    )
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
            $this->saveMeetingLink($event->eventType->location_type, $event,$zoomService, $whaleService);
            $event->eventType->owner->notify(new NotificationBeforeEventForOwner($event));
            Notification::route('mail', $event->invitee_email)
                ->notify(new NotificationBeforeEventForInvitee($event));
            $event->notified = true;
            $eventRepository->save($event);
        }
    }

    private function saveMeetingLink(string $location, Event $event, ZoomService $zoomService, WhaleService $whaleService): void
    {
        switch ($location) {
            case $location == 'zoom':
                $event->zoom_meeting_link = $zoomService->meeting($event);
                $event->save();
            break;
            case $location == 'whale':
                $event->whale_meeting_link = $whaleService->meeting($event);
                $event->save();
            break;
        }
    }
}
