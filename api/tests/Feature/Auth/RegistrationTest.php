<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

    public function test_registration_with_invalid_email()
    {
        $user = [
            'email' => 'invalid@',
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'timezone' => $this->faker->timezone,
        ];

        $response = $this->json('POST', '/api/v1/auth/register', $user);

        $response->assertStatus(422)
            ->assertJson(['error'=>['message' => 'The given data was invalid.']])
            ->assertJson(['error'=>['validator' => ['email' => ['The email must be a valid email address.']]]]);

        $this->assertDatabaseMissing('users', [
            'email' => $user['email'],
            'name' => $user['name'],
            'timezone' => $user['timezone'],
        ]);
    }

    public function test_registration_with_empty_email()
    {
        $user = [
            'email' => '',
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'timezone' => $this->faker->timezone,
        ];

        $response = $this->json('POST', '/api/v1/auth/register', $user);

        $response->assertStatus(422)
            ->assertJson(['error'=>['message' => 'The given data was invalid.']])
            ->assertJson(['error'=>['validator' => ['email' => ['The email field is required.']]]]);

        $this->assertDatabaseMissing('users', [
            'email' => $user['email'],
            'name' => $user['name'],
            'timezone' => $user['timezone'],
        ]);
    }

    public function test_registration_with_invalid_password_confirmation()
    {
        $user = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => 'invalid',
            'timezone' => $this->faker->timezone,
        ];

        $response = $this->json('POST', '/api/v1/auth/register', $user);

        $response->assertStatus(422)
            ->assertJson(['error'=>['message' => 'The given data was invalid.']])
            ->assertJson(['error'=>['validator' => ['password' => ['The password confirmation does not match.']]]]);

        $this->assertDatabaseMissing('users', [
            'email' => $user['email'],
            'name' => $user['name'],
            'timezone' => $user['timezone'],
        ]);
    }

    public function test_registration_with_invalid_email_been_taken()
    {
        $user = [
            'email' => 'test@gmail.com',
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'timezone' => $this->faker->timezone,
        ];

        factory(User::class)->create([
            'name' => $this->faker->name,
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ]);

        $response = $this->json('POST', '/api/v1/auth/register', $user);

        $response->assertStatus(422)
            ->assertJson(['error'=>['message' => 'The given data was invalid.']])
            ->assertJson(['error'=>['validator' => ['email' => ['The email has already been taken.']]]]);
    }
}
