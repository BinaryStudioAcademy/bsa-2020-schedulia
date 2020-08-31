<?php

namespace App\Jobs;


use App\Mail\BeforeEventMailForInvitee;
use App\Mail\EventCreatedMailToInvitee;
use App\Notifications\NotificationBeforeEventForInvitee;
use App\Notifications\NotificationBeforeEventForOwner;
use App\Repositories\Event\Criterion\EndDateCriterion;
use App\Repositories\Event\Criterion\OwnerCriterion;
use App\Repositories\Event\Criterion\StartDateCriterion;
use App\Repositories\Event\EventRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendNotificationBeforeEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {

    }

    public function handle(EventRepository $eventRepository)
    {
        $tenMinutesFutureBigger = (new \DateTime())->modify('+610 seconds');
        $tenMinutesFutureLess = (new \DateTime())->modify('+590 seconds');
        $criteria = [new StartDateCriterion($tenMinutesFutureLess->format('Y-m-d H:i:s')),
            new EndDateCriterion($tenMinutesFutureBigger->format('Y-m-d H:i:s'))];
        $events = $eventRepository->findByCriteria(...$criteria);

        foreach ($events as $event) {
            $event->eventType->owner->notify(new NotificationBeforeEventForOwner($event));
            Notification::route('mail', $event->invitee_email)
                ->notify(new NotificationBeforeEventForInvitee($event));
        }
    }
}
