<?php

use App\Product\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id'   => $faker->numberBetween(1, 5),
        'category_id' => $faker->numberBetween(1, 20),
        'name'       => $faker->word(),
    ];
});
