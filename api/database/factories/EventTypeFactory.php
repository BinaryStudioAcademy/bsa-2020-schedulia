<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\EventType;
use Faker\Generator as Faker;

$factory->define(EventType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'slug' =>  $faker->slug,
        'color' => $faker->colorName,
        'duration' => $faker->randomNumber(),
        'timezone' => $faker->timezone,
        'disabled' => $faker->boolean,
    ];
});
