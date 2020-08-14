<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\Availability;
use Faker\Generator as Faker;

$factory->define(Availability::class, function (Faker $faker) {
    return [
        'type' => 'day',
        'start_date' => $faker->dateTime->format('Y-m-d H:i:s'),
        'end_date' => $faker->dateTime->format('Y-m-d H:i:s')
    ];
});
