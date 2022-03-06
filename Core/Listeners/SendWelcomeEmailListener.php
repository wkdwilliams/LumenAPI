<?php

namespace Core\Listeners;

use Core\Events\ExampleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmailListener implements ShouldQueue
{

    public function handle($event)
    {
        echo $event->entity->getEmail(); // Returns email of newly created user
    }
}
