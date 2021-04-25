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
        \Core\Events\ExampleEvent::class => [
            \Core\Listeners\ExampleListener::class,
        ],
    ];
}
