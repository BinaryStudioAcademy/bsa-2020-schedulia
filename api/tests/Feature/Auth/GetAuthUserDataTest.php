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
            'password' => Hash::make($password = '12345678'),
            'timezone' => 'Europe/Amsterdam'
        ]);

        $this->json('POST','/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->json('GET','/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'=>['email', 'name', 'timezone']]);

        $responseData =  json_decode($response->getContent(), true);

        $this->assertEquals($user->name, $responseData['data']['name']);
        $this->assertEquals($user->email, $responseData['data']['email']);
        $this->assertEquals($user->timezone, $responseData['data']['timezone']);
    }

    public function test_unauthenticated_request_return_correct_status()
    {
        $response = $this->json('GET','/api/v1/auth/me');

        $response->assertStatus(401);
    }
}
