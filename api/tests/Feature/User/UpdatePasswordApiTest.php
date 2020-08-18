<?php

namespace Tests\Feature\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePasswordApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticated()
    {
        $data = [
            'password' => '12345678',
            'oldPassword' => 'qwertyui'
        ];

        $response = $this->json("PUT", "/api/v1/profiles/me/password", $data);

        $response->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(
                [
                    "error" => ["message" => 'Unauthenticated.']
                ]
            );
    }

    public function testInvalidDate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json("PUT", "/api/v1/profiles/me/password", [
            "password" => "12"
        ]);

        $response->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json');
    }

    public function testInvalidPasswordData()
    {
        $user = factory(User::class)->create();

        $dataToUpdate = [
            "password" => "12345678",
            "oldPassword" => "passwordss",
        ];

        $response = $this->actingAs($user)->json("PUT", "/api/v1/profiles/me/password", $dataToUpdate);

        $response->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonFragment(['message' => 'Invalid old password has been provided']);
    }

    public function testValidData()
    {
        $user = factory(User::class)->create();

        $dataToUpdate = [
            "password" => "12345678",
            "oldPassword" => "password",
        ];

        $response = $this->actingAs($user)->json("PUT", "/api/v1/profiles/me/password", $dataToUpdate);

        $response->assertStatus(204);
    }
}
