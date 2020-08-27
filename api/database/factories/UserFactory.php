<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $email = "schedulia-test@schedulia.xyz";

    return [
        'name' => $faker->name,
        'email' => $email,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'timezone' => $faker->timezone,
        'branding_logo' => $faker->imageUrl(400, 200),
        'avatar' => $faker->imageUrl(200, 200),
        'welcome_message' => $faker->text(250),
        'language' => 'en',
        'date_format' => 'american',
        'time_format_12h' => $faker->boolean(50),
        'country' => $faker->country,
        'timezone' => $faker->timezone,
        'nickname' => Hash::make($email)
    ];
});
