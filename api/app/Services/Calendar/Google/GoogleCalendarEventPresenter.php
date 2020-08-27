<?php

namespace App\Services\Calendar\Google;


use App\Contracts\PresenterInterface;

class GoogleCalendarEventPresenter implements PresenterInterface
{
    public static function present(GoogleCalendarEvent $event): array
    {
        return [
            'summary' => $event->getSummary(),
            'location' => $event->getLocation(),
            'description' => $event->getDescription(),
            'start' => [
                'dateTime' => $event->getStartTime()
            ],
            'end' => [
                'dateTime' => $event->getEndTime()
            ],
            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => [
                    [
                        'method' => 'email',
                        'minutes' => 24 * 60
                    ],
                    [
                        'method' => 'popup',
                        'minutes' => 10
                    ],
                ],
            ],
        ];
    }
}