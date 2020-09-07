<?php

declare(strict_types=1);

namespace Tests\Feature\AvailabilityService;

use App\Entity\Availability;
use App\Entity\CustomField;
use App\Entity\CustomFieldValue;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use App\Exceptions\ErrorCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use App\Events\EventCreated;
use Illuminate\Support\Facades\Event as EventFaker;
use Tests\TestCase;

class AvailabilityServiceTest extends TestCase
{
    use RefreshDatabase;

    private const EVENT_TYPES_API_URL = 'api/v1/event-types';
    private const EVENT_API_URL = 'api/v1/events';

    private const DATE_RANGE_AVAILABILITY = [
        'type' => 'date_range',
        'start_date' => '2020-08-07 11:00:00',
        'end_date' => '2020-08-10 22:00:00',
    ];

    private const EVERY_MONDAY_AVAILABILITY = [
        'type' => 'every_monday',
        'start_date' => '2020-08-10 15:00:00',
        'end_date' => '2020-08-10 19:00:00'
    ];

    private const END_TIME_BEFORE_START_TIME_AVAILABILITY = [
        'type' => 'date_range',
        'start_date' => '2020-08-09 20:00:00',
        'end_date' => '2020-08-09 15:00:00'
    ];

    private const UNKNOWN_AVAILABILITY_TYPE = [
        'type' => 'unknown_type',
        'start_date' => '2020-08-09 14:00:00',
        'end_date' => '2020-08-09 15:00:00'
    ];

    private const AVAILABILITY_FROM_NOT_ONE_DAY = [
        'type' => 'every_monday',
        'start_date' => '2020-08-07 11:00:00',
        'end_date' => '2020-08-10 15:00:00'
    ];

    private const SMALL_INTERVAL_AVAILABILITY = [
        'type' => 'date_range',
        'start_date' => '2020-08-10 11:00:00',
        'end_date' => '2020-08-10 11:30:00'
    ];

    private const EVENT_TYPE_DATA_VALID_AVAILABILITIES = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::DATE_RANGE_AVAILABILITY
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_END_TIME_BEFORE_START_TIME_INVALID = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::END_TIME_BEFORE_START_TIME_AVAILABILITY
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_SMALL_INTERVAL = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::SMALL_INTERVAL_AVAILABILITY
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_WITHOUT_MAIN_AVAILABILITY = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::EVERY_MONDAY_AVAILABILITY
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_WITH_UNKNOWN_AVAILABILITY = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::DATE_RANGE_AVAILABILITY,
            self::UNKNOWN_AVAILABILITY_TYPE,
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_WITH_WRONG_AVAILABILITY_INTERVAL = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::DATE_RANGE_AVAILABILITY,
            self::AVAILABILITY_FROM_NOT_ONE_DAY,
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_WITH_AVAILABILITY_OVERLAPPED_INTERVALS = [
        'name' => 'EventType',
        'description' => '',
        'slug' => 'event-type-slug',
        'color' => 'red',
        'duration' => 60,
        'timezone' => 'Europe/Kiev',
        'disabled' => true,
        'availabilities' => [
            self::DATE_RANGE_AVAILABILITY,
            [
                'type' => 'exact_date',
                'start_date' => '2020-08-08 10:00:00',
                'end_date' => '2020-08-08 15:00:00',
            ],
            [
                'type' => 'exact_date',
                'start_date' => '2020-08-08 13:00:00',
                'end_date' => '2020-08-08 19:00:00',
            ],
        ],
        'location_type' => 'zoom'
    ];

    private const EVENT_TYPE_STRUCTURE = [
        'name',
        'description',
        'slug',
        'color',
        'duration',
        'disabled',
        'timezone',
        'owner' => [
            'id',
            'email',
            'name',
            'timezone'
        ],
        'availabilities',
        'location_type',
        'coordinates'
    ];

    private const AVAILABILITY_STRUCTURE = [
        'type',
        'start_date',
        'end_date'
    ];

    private const ERROR_RESPONSE_STRUCTURE = [
        'error' => [
            'message',
            'code'
        ]
    ];

    public function test_add_event_type_valid_availabilities()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_DATA_VALID_AVAILABILITIES
            );

        $response
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson(['data' => self::EVENT_TYPE_DATA_VALID_AVAILABILITIES])
            ->assertJson(['data' => [
                'owner' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'timezone' => $user->timezone
                ]
            ]])
            ->assertJsonStructure(['data' => self::EVENT_TYPE_STRUCTURE])
            ->assertJsonStructure([
                'data' => [
                    'availabilities' => [
                       '*' => self::AVAILABILITY_STRUCTURE
                    ]
                ]
            ]);
    }

    public function test_add_event_type_end_time_before_start_time_availability()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_END_TIME_BEFORE_START_TIME_INVALID
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                    'message' => 'Your end time cannot be before your start time!',
                    'code' => ErrorCode::END_TIME_BEFORE_START_TIME_EXCEPTION
                ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_type_small_interval_availability()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_SMALL_INTERVAL
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                    'message' => 'Intervals must be at least 60 minutes!',
                    'code' => ErrorCode::AVAILABILITY_VALIDATION_EXCEPTION
                ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_type_without_main_availability()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_WITHOUT_MAIN_AVAILABILITY
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                'message' => 'There must be availability with type \'date_range*\'',
                'code' => ErrorCode::AVAILABILITY_VALIDATION_EXCEPTION
            ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_type_with_unknown_availability()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_WITH_UNKNOWN_AVAILABILITY
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                    'message' => 'Unknown Availability type!',
                    'code' => ErrorCode::UNKNOWN_AVAILABILITY_TYPE
                ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_type_with_availability_with_wrong_interval()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_WITH_WRONG_AVAILABILITY_INTERVAL
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                'message' => 'Date for Availability with type \'every_monday\' must be from one day!',
                'code' => ErrorCode::AVAILABILITY_VALIDATION_EXCEPTION
            ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_type_with_overlapped_intervals()
    {
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL,
                self::EVENT_TYPE_WITH_AVAILABILITY_OVERLAPPED_INTERVALS
            );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson(['error' => [
                'message' => 'Intervals are overlapping!',
                'code' => ErrorCode::INTERVALS_OVERLAPPED_EXCEPTION
            ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    public function test_add_event_unbooked_time()
    {
        EventFaker::fake([EventCreated::class]);

        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $eventType->customFields()->createMany($this->returnDataForCustomFields());
        $this->assertEquals(2, $eventType->customFields()->count());

        $availability = new Availability();
        $availability->event_type_id = $eventType->id;
        $availability->type = 'date_range';
        $availability->start_date = '2020-08-07 11:00:00';
        $availability->end_date = '2020-08-10 22:00:00';
        $availability->save();

        $response = $this->json('POST', self::EVENT_API_URL, $this->returnEventDataByEventTypeId($eventType));

        $response->assertStatus(JsonResponse::HTTP_CREATED);
    }

    public function test_add_event_on_booked_time()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();

        $availability = new Availability();
        $availability->event_type_id = $eventType->id;
        $availability->type = 'date_range';
        $availability->start_date = '2020-08-07 11:00:00';
        $availability->end_date = '2020-08-10 22:00:00';
        $availability->save();

        $this->json('POST', self::EVENT_API_URL, $this->returnEventDataByEventTypeId($eventType));
        $response = $this->json('POST', self::EVENT_API_URL, $this->returnEventDataByEventTypeId($eventType));

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJson([
                'error' => [
                    'message' => 'Chosen time is already booked!',
                    'code' => ErrorCode::TIME_IS_ALREADY_BOOKED
                ]
            ])
            ->assertJsonStructure(self::ERROR_RESPONSE_STRUCTURE);
    }

    private function returnDataForCustomFields()
    {
        return [
            [
                'name' => 'Question 1',
                'type' => 'line'
            ],
            [
                'name' => 'Question 2',
                'type' => 'line'
            ]
        ];
    }

    private function returnEventDataByEventTypeId(EventType $eventType)
    {
        $customField = new CustomField([
            'event_type_id' => $eventType->id,
            'type' => 'line',
            'name' => 'question'
        ]);
        $customField->save();

        return [
            'event_type_id' => $eventType->id,
            'invitee_name' => 'Invitee Name',
            'invitee_email' => 'invitee@gmail.com',
            'timezone' => 'Europe/Kiev',
            'start_date' => '2020-08-07 15:00:00',
            'custom_field_values' => [
                [
                    'custom_field_id' => $customField->id,
                    'value' => 'answer'
                ]
            ]
        ];
    }

    public function test_get_available_event_type_time_date_range()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $availability = new Availability([
            'event_type_id' => $eventType->id,
            'type' => 'date_range',
            'start_date' => '2020-08-07 11:00:00',
            'end_date' => '2020-08-10 22:00:00'
        ]);
        $availability->save();

        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-09' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }

    public function test_get_available_event_type_time_date_range_with_booked_time()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $availability = new Availability([
            'event_type_id' => $eventType->id,
            'type' => 'date_range',
            'start_date' => '2020-08-07 11:00:00',
            'end_date' => '2020-08-10 22:00:00'
        ]);
        $availability->save();

        $event = new Event([
            'event_type_id' => $eventType->id,
            'invitee_name' => 'Invitee Name',
            'invitee_email' => 'inv@gmail.com',
            'timezone' => 'Europe/Kiev',
            'start_date' => '2020-08-08 15:00:00'
        ]);
        $event->save();

        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => [
                                '15:00:00'
                            ]
                        ]
                    ],
                    '2020-08-09' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }

    public function test_get_available_event_type_time_date_range_with_exact_date()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $eventType->availabilities()->saveMany([
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'date_range',
                'start_date' => '2020-08-07 11:00:00',
                'end_date' => '2020-08-10 22:00:00'
            ]),
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'exact_date',
                'start_date' => '2020-08-08 17:00:00',
                'end_date' => '2020-08-08 20:30:00'
            ])
        ]);
        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [
                        [
                            'type' => 'exact_date',
                            'start_time' => '17:00:00',
                            'end_time' => '20:30:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-09' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }

    public function test_get_available_event_type_time_date_range_every_type()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();

        $eventType->availabilities()->saveMany([
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'date_range',
                'start_date' => '2020-08-07 11:00:00',
                'end_date' => '2020-08-10 22:00:00'
            ]),
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'every_saturday',
                'start_date' => '2020-08-08 17:00:00',
                'end_date' => '2020-08-08 20:30:00'
            ]),
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'every_saturday',
                'start_date' => '2020-08-08 21:00:00',
                'end_date' => '2020-08-09 00:00:00'
            ])
        ]);
        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [
                        [
                            'type' => 'every_saturday',
                            'start_time' => '17:00:00',
                            'end_time' => '20:30:00',
                            'unavailable' => []
                        ],
                        [
                            'type' => 'every_saturday',
                            'start_time' => '21:00:00',
                            'end_time' => '00:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-09' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }

    public function test_get_available_event_type_time_date_range_weekdays()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $eventType->availabilities()->saveMany([
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'date_range_weekdays',
                'start_date' => '2020-08-07 11:00:00',
                'end_date' => '2020-08-10 22:00:00'
            ])
        ]);
        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range_weekdays',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [],
                    '2020-08-09' => [],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range_weekdays',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }

    public function test_get_available_event_type_time_date_range_weekdays_with_exact_date()
    {
        $user = factory(User::class)->create();
        $eventType = new EventType([
            'owner_id' => $user->id,
            'name' => 'EventType',
            'description' => '',
            'slug' => 'event-type-slug',
            'color' => 'red',
            'duration' => 60,
            'timezone' => 'Europe/Kiev',
            'disabled' => true,
            'location_type' => 'zoom'
        ]);
        $eventType->save();
        $eventType->availabilities()->saveMany([
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'date_range_weekdays',
                'start_date' => '2020-08-07 11:00:00',
                'end_date' => '2020-08-10 22:00:00'
            ]),
            new Availability([
                'event_type_id' => $eventType->id,
                'type' => 'exact_date',
                'start_date' => '2020-08-08 17:00:00',
                'end_date' => '2020-08-08 20:30:00'
            ])
        ]);
        $response = $this->json('GET', self::EVENT_TYPES_API_URL . '/' . $eventType->id . '/availabilities?month=2020-08');

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    '2020-08-07' => [
                        [
                            'type' => 'date_range_weekdays',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-08' => [
                        [
                            'type' => 'exact_date',
                            'start_time' => '17:00:00',
                            'end_time' => '20:30:00',
                            'unavailable' => []
                        ]
                    ],
                    '2020-08-09' => [],
                    '2020-08-10' => [
                        [
                            'type' => 'date_range_weekdays',
                            'start_time' => '11:00:00',
                            'end_time' => '22:00:00',
                            'unavailable' => []
                        ]
                    ],
                ]
            ]);
    }
}
