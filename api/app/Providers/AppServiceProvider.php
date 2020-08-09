<?php

namespace App\Providers;

use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        EventTypeRepositoryInterface::class => EventTypeRepository::class,
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
