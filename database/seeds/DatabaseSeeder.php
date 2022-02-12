<?php

use App\Message\Models\Message;
use App\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();
        factory(Message::class, 5)->create();
        //$this->call(UserSeeder::class);
        //$this->call(MessageSeeder::class);
    }
}
