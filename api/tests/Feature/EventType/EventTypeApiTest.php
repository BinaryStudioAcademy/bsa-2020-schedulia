<?php

declare(strict_types=1);

namespace Tests\Feature\EventType;

use App\Entity\Availability;
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
        'availabilities' => [
            [
                'type' => 'date_range',
                'start_date' => '2020-08-06 11:00:00',
                'end_date' => '2020-08-06 22:00:00',
            ]
        ],
        'location_type' => 'zoom'
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
        ],
        'availabilities',
        'location_type'
    ];

    private const STRUCTURE_AVAILABILITIES = [
        'type',
        'start_date',
        'end_date'
    ];

    public function test_get_event_type_collection()
    {
        $user = factory(User::class)->create();

        factory(EventType::class, 3)->create([
            'owner_id' => $user->id,
        ])->each(function ($eventType) {
            $eventType->availabilities()->saveMany(
                factory(Availability::class, 2)
            );
        });

        $response = $this
            ->actingAs($user)
            ->json('GET', self::API_URL);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => self::STRUCTURE]])
            ->assertJsonStructure(['data' => [
                '*' => [
                    "availabilities" => ['*' => self::STRUCTURE_AVAILABILITIES]
                ]
            ]]);
    }

    public function test_get_empty_event_type_collection()
    {
        $user = factory(User::class)->create();

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
        $user = factory(User::class)->create();

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        factory(Availability::class, 2)->create([
            'event_type_id' => $eventType->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->json('GET', self::API_URL . '/' . $eventType->id);

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['data' => self::STRUCTURE])
            ->assertJsonStructure(['data' => [
                    "availabilities" => ['*' => self::STRUCTURE_AVAILABILITIES]
                ]
            ]);
    }

    public function test_get_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->json('GET', self::API_URL . '/' . 0)
            ->assertNotFound();
    }

    public function test_add_event_type()
    {
        $user = factory(User::class)->create();

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
            ->assertJsonStructure(['data' => self::STRUCTURE])
            ->assertJsonStructure(['data' => [
                "availabilities" => ['*' => self::STRUCTURE_AVAILABILITIES]
            ]
            ]);
    }

    public function test_add_event_type_invalid_request_params()
    {
        $user = factory(User::class)->create();

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

    public function test_add_event_type_invalid_availability_request_params()
    {
        $user = factory(User::class)->create();

        $data = self::DATA;
        $data['availabilities'] = [
            [
                'type' => 'week',
                'start_date' => 'string',
                'end_date' => 'string',
            ]
        ];

        $response = $this
            ->actingAs($user)
            ->json('POST', self::API_URL, $data);

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
        $user = factory(User::class)->create();

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        factory(Availability::class, 2)->create([
            'event_type_id' => $eventType->id,
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
            ->assertJsonStructure(['data' => self::STRUCTURE])
            ->assertJsonStructure(['data' => [
                    "availabilities" => ['*' => self::STRUCTURE_AVAILABILITIES]
                ]
            ]);
    }

    public function test_update_event_type_by_id_forbidden()
    {
        $authorizedUser = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $eventType = factory(EventType::class)->create([
            'owner_id' => $anotherUser->id,
        ]);

        $this
            ->actingAs($authorizedUser)
            ->json('PUT', self::API_URL . '/' . $eventType->id, self::DATA)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }

    public function test_update_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->json('PUT', self::API_URL . '/' . 0, self::DATA)
            ->assertNotFound();
    }

    public function test_delete_event_type_by_id()
    {
        $user = factory(User::class)->create();

        $eventType = factory(EventType::class)->create([
            'owner_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->json('DELETE', self::API_URL . '/' . $eventType->id)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }

    public function test_delete_event_type_by_id_not_found()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->json('DELETE', self::API_URL . '/' . 0)
            ->assertNotFound();
    }

    public function test_delete_event_type_by_id_forbidden()
    {
        $authorizedUser = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $eventType = factory(EventType::class)->create([
            'owner_id' => $anotherUser->id,
        ]);

        $this
            ->actingAs($authorizedUser)
            ->json('DELETE', self::API_URL . '/' . $eventType->id, self::DATA)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }
}
