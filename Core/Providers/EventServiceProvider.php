<?php

namespace Core\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Core\Events\UserCreated::class => [
            \Core\Listeners\SendWelcomeEmailListener::class,
        ],
    ];
}
