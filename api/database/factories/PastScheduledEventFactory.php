<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Entity\Event;
use App\Entity\Tweet;
use \App\Entity\EventType;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'invitee_name' => $faker->name,
        'event_type_id' => EventType::query()->inRandomOrder()->first()->id,
        'invitee_email' => $faker->email,
        'start_date' => $faker->dateTimeBetween('-1 day', '-2 month'),
        'timezone' => $faker->timezone,
        'status' => 'scheduled',
        'created_at' => $now->toDateTimeString(),
    ];
});
