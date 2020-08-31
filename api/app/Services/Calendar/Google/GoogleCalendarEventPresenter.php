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
            'colorId' => $event->getColorAccordingGoogle(),
            'start' => [
                'dateTime' => $event->getStartTime(),
                'timeZone' => 'UTC'
            ],
            'end' => [
                'dateTime' => $event->getEndTime(),
                'timeZone' => 'UTC'
            ],
            'attendees' => [
                [
                    'email' => $event->getAttendeeEmail()
                ]
            ],
            'reminders' => [
                'useDefault' => false,
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
