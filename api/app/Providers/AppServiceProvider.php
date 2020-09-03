<?php

namespace App\Providers;

use App\Contracts\AvailabilityServiceInterface;
use App\Repositories\Availability\AvailabilityRepository;
use App\Repositories\Availability\AvailabilityRepositoryInterface;
use App\Repositories\ElasticSearch\Events\ElasticsearchEventAggregateRepository;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use App\Repositories\EventCalendar\EventCalendarRepository;
use App\Repositories\EventCalendar\EventCalendarRepositoryInterface;
use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\SocialAccount\SocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Availability\AvailabilityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        EventTypeRepositoryInterface::class => EventTypeRepository::class,
        EventRepositoryInterface::class => EventRepository::class,
        AvailabilityServiceInterface::class => AvailabilityService::class,
        AvailabilityRepositoryInterface::class => AvailabilityRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        SocialAccountRepositoryInterface::class => SocialAccountRepository::class,
        EventAggregateRepositoryInterface::class => ElasticsearchEventAggregateRepository::class,
        TagRepositoryInterface::class => TagRepository::class,
        EventCalendarRepositoryInterface::class => EventCalendarRepository::class
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
