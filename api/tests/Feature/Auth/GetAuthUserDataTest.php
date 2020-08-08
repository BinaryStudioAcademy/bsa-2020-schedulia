<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GetAuthUserDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_request_return_user_data()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Amsterdam'
        ]);

        $response = $this->withJwt($user)->json('GET', '/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'=>['email', 'name', 'timezone']])
            ->assertJson([
                'data' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'timezone' => $user->timezone,
                ]
            ]);
    }

    public function test_unauthenticated_request_return_correct_status()
    {
        $response = $this->json('GET', '/api/v1/auth/me');

        $response->assertStatus(401);
    }
}
