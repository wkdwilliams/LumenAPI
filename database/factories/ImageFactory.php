<?php

use App\Image\Models\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'message_id' => 1,
        'url'        => $faker->url
    ];
});
