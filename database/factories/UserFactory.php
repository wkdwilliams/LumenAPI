<?php

use App\User\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'email'     => $faker->email,
        'password'  => Hash::make("pass")
    ];
});
