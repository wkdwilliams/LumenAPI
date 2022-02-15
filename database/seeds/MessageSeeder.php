<?php

use App\Message\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        factory(Message::class, 5)->create();
    }
}
