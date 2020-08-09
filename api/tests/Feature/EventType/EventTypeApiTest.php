<?php

declare(strict_types=1);

namespace Tests\Feature\EventType;

use App\Entity\EventType;
use App\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

final class EventTypeApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_URL = 'api/v1/event-types';

    private const DATA = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'test',
        'color' => '#7FFF00',
        'duration' => 30,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
    ];

    private const STRUCTURE = [
        'name',
        'description',
        'slug',
        'color',
        'duration',
        'timezone',
        'disabled',
        'owner' => [
            'id',
            'email',
            'name',
            'timezone'
        ]
    ];

    public function test_get_event_type_collection()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        factory(EventType::class, 3)->create([
            'owner_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->json('GET', self::API_URL);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => self::STRUCTURE]]);
    }

    public function test_get_empty_event_type_collection()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $response = $this
            ->actingAs($user)
            ->json('GET', self::API_URL);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure(['data' => []]);
    }

    public function test_get_event_type_collection_unauthorized()
    {
        $this
            ->json('GET', self::API_URL)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function test_get_event_type_by_id()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->json('GET', self::API_URL . '/' . $eventType->id);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['data' => self::STRUCTURE]);
    }

    public function test_get_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $this
            ->actingAs($user)
            ->json('GET', self::API_URL . '/' . 0)
            ->assertNotFound();
    }

    public function test_add_event_type()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $response = $this
            ->actingAs($user)
            ->json('POST', self::API_URL, self::DATA);

        $response
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson(['data' => self::DATA])
            ->assertJson([
                'data' => [
                    'owner' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                        'timezone' => $user->timezone,
                    ]
                ]
            ])
            ->assertJsonStructure(['data' => self::STRUCTURE]);
    }

    public function test_add_event_type_invalid_request_params()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $response = $this
            ->actingAs($user)
            ->json('POST', self::API_URL, []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'message',
                    'validator',
                ]
            ]);
    }

    public function test_update_event_type_by_id()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->json('PUT', self::API_URL . '/' . $eventType->id, self::DATA);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson(['data' => self::DATA])
            ->assertJson([
                'data' => [
                    'owner' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                        'timezone' => $user->timezone,
                    ]
                ]
            ])
            ->assertJsonStructure(['data' => self::STRUCTURE]);
    }

    public function test_update_event_type_by_id_forbidden()
    {
        $users = factory(User::class, 2)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $eventType = factory(EventType::class)->create([
            'owner_id' => $users[0]['id'],
        ]);

        $this
            ->actingAs($users[1])
            ->json('PUT', self::API_URL . '/' . $eventType->id, self::DATA)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }

    public function test_update_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $this
            ->actingAs($user)
            ->json('PUT', self::API_URL . '/' . 0, self::DATA)
            ->assertNotFound();
    }

    public function test_delete_event_type_by_id()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->json('DELETE', self::API_URL . '/' . $eventType->id)
            ->assertStatus(204);
    }

    public function test_delete_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $this
            ->actingAs($user)
            ->json('DELETE', self::API_URL . '/' . 0)
            ->assertNotFound();
    }

    public function test_delete_event_type_by_id_forbidden()
    {
        $users = factory(User::class, 2)->create([
            'timezone' => 'Europe/Kiev'
        ]);

        $eventType = factory(EventType::class)->create([
            'owner_id' => $users[0]['id'],
        ]);

        $this
            ->actingAs($users[1])
            ->json('DELETE', self::API_URL . '/' . $eventType->id, self::DATA)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }
}
