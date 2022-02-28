<?php

use App\Product\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'userid'     => $faker->numberBetween(1, 5),
        'categoryid' => $faker->numberBetween(1, 20),
        'name'       => $faker->word(),
    ];
});
