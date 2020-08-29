<?php

namespace App\Providers;

use App\Events\EventCreated;
use App\Listeners\AddEventToGoogleCalendar;
use App\Listeners\SendEventCreatedNotificationToInvitee;
use App\Listeners\SendEventCreatedNotificationToOwner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventCreated::class => [
            SendEventCreatedNotificationToOwner::class,
            SendEventCreatedNotificationToInvitee::class,
            AddEventToGoogleCalendar::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
