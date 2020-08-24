<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use \App\Entity\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'invitee_name' => $faker->name,
        'invitee_email' => $faker->email,
        'start_date' => $faker->dateTimeBetween('-2 days', '+2 days'),
        'timezone' => $faker->timezone,
    ];
});
