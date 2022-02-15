<?php

use App\Message\Models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'message' => implode(' ', $faker->words)
    ];
});
