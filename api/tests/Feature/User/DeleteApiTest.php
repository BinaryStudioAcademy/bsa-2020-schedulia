<?php

namespace Tests\Feature\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticated()
    {
        $response = $this->json("DELETE", "/api/v1/profiles/me");

        $response->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(
                [
                    "error" => ["message" => 'Unauthenticated.']
                ]
            );
    }

    public function testValidData()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json("DELETE", "/api/v1/profiles/me");

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseMissing('users', $user->attributesToArray());
    }
}
