<?php

namespace App\Providers;

use App\Contracts\AvailabilityServiceInterface;
use App\Repositories\Availability\AvailabilityRepository;
use App\Repositories\Availability\AvailabilityRepositoryInterface;
use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\SocialAccount\SocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Availability\AvailabilityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        EventTypeRepositoryInterface::class => EventTypeRepository::class,
        AvailabilityServiceInterface::class => AvailabilityService::class,
        AvailabilityRepositoryInterface::class => AvailabilityRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        SocialAccountRepositoryInterface::class => SocialAccountRepository::class
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
