<?php

namespace App\Providers;

use App\Contracts\AvailabilityServiceInterface;
use App\Repositories\Availability\AvailabilityRepository;
use App\Repositories\Availability\AvailabilityRepositoryInterface;
use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Services\Availability\AvailabilityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        EventTypeRepositoryInterface::class => EventTypeRepository::class,
        EventRepositoryInterface::class => EventRepository::class,
        AvailabilityServiceInterface::class => AvailabilityService::class,
        AvailabilityRepositoryInterface::class => AvailabilityRepository::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
