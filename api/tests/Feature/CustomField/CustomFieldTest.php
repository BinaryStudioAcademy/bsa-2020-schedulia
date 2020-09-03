<?php

declare(strict_types=1);

namespace Tests\Feature\CustomField;

use App\Entity\Availability;
use App\Entity\CustomField;
use App\Entity\EventType;
use App\Entity\User;
use App\Events\EventCreated;
use Illuminate\Support\Facades\Event as EventFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CustomFieldTest extends TestCase
{
    use RefreshDatabase;

    private const EVENT_TYPES_API_URL = 'api/v1/event-types';
    private const EVENT_API_URL = 'api/v1/events';

    private const CUSTOM_FIELDS_VALID = [
        [
            'name' => 'Field name',
            'type' => 'line'
        ],
        [
            'name' => 'Field name',
            'type' => 'line'
        ]
    ];

    private const CUSTOM_FIELDS_INVALID_TYPE = [
        [
            'name' => 'Field name',
            'type' => 'unknown'
        ]
    ];

    private const CUSTOM_FIELDS_WRONG_REQUEST_FIELDS_TYPES = [
        [
            'name' => [],
            'type' => 123
        ]
    ];

    public function test_add_event_type_with_custom_fields_success()
    {
        $user = factory(User::class)->create();
        $eventType = factory(EventType::class)->create(['owner_id' => $user->id]);

        $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL . '/'
                . $eventType->id .
                '/custom-fields',
                ['custom_fields' => self::CUSTOM_FIELDS_VALID]
            )
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }

    public function test_add_event_type_with_custom_field_invalid_type()
    {
        $user = factory(User::class)->create();
        $eventType = factory(EventType::class)->create(['owner_id' => $user->id]);

        $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL . '/'
                . $eventType->id .
                '/custom-fields',
                ['custom_fields' => self::CUSTOM_FIELDS_INVALID_TYPE]
            )
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_add_event_type_with_custom_field_invalid_request_types()
    {
        $user = factory(User::class)->create();
        $eventType = factory(EventType::class)->create(['owner_id' => $user->id]);

        $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_TYPES_API_URL . '/'
                . $eventType->id .
                '/custom-fields',
                ['custom_fields' => self::CUSTOM_FIELDS_WRONG_REQUEST_FIELDS_TYPES]
            )
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_add_event_with_custom_field_values_success()
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

        $availability = new Availability();
        $availability->event_type_id = $eventType->id;
        $availability->type = 'date_range';
        $availability->start_date = '2020-08-07 11:00:00';
        $availability->end_date = '2020-08-10 22:00:00';
        $availability->save();

        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_API_URL,
                $this->returnEventDataByEventTypeValid($eventType)
            );

        $response
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }

    public function test_add_event_with_custom_field_values_invalid()
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

        $response = $this
            ->actingAs($user)
            ->json(
                'POST',
                self::EVENT_API_URL,
                $this->returnEventDataByEventTypeInValid($eventType)
            );

        $response
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function returnEventDataByEventTypeValid(EventType $eventType)
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
            'custom_field_values' => $this->getValidCustomFieldValues($customField->id)
        ];
    }

    private function returnEventDataByEventTypeInValid(EventType $eventType)
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
            'custom_field_values' => $this->getInValidCustomFieldValues($customField->id)
        ];
    }

    private function getValidCustomFieldValues($customFieldId)
    {
        return [
            [
                'custom_field_id' => $customFieldId,
                'value' => 'answer'
            ]
        ];
    }

    private function getInValidCustomFieldValues($customFieldId)
    {
        return [
            [
                'custom_field_id' => $customFieldId,
                'value' => 123
            ]
        ];
    }
}
