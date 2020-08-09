<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Faker\Factory as Faker;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
    }


    public function test_registration_with_valid_data()
    {
        $user = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'timezone' => $this->faker->timezone,
        ];

        $response = $this->json('POST', '/api/v1/auth/register', $user);

        $response->assertStatus(201)
            ->assertJsonStructure(['data'=>['id', 'email', 'name', 'timezone']]);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
            'name' => $user['name'],
            'timezone' => $user['timezone'],
        ]);
    }
}
