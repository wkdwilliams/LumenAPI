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
        file_put_contents(sys_get_temp_dir()."/out.txt", "Hello");
    }
}
