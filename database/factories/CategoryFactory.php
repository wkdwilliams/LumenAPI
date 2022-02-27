<?php

use App\Category\Models\Category;
use Faker\Generator as Faker;
    
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word()
    ];
});
