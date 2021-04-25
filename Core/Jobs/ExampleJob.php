<?php

namespace Core\Jobs;

use App\User\Models\User;
use Illuminate\Queue\SerializesModels;

class ExampleJob extends Job
{
    use SerializesModels;

    public function handle(): void
    {
        sleep(10);
        factory(User::class, 5)->create();
    }
}
