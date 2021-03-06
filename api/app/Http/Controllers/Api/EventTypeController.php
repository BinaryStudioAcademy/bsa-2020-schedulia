<?php

namespace App\Http\Controllers\Api;

use App\Actions\CustomField\AddCustomFieldsToEventTypeAction;
use App\Actions\CustomField\AddCustomFieldsToEventTypeRequest;
use App\Actions\CustomField\GetCustomFieldCollectionByEventTypeIdAction;
use App\Actions\CustomField\GetCustomFieldCollectionByEventTypeIdRequest;
use App\Actions\EventType\AddEventTypeAction;
use App\Actions\EventType\AddEventTypeRequest;
use App\Actions\EventType\ChangeDisabledByIdAction;
use App\Actions\EventType\ChangeDisabledByIdRequest;
use App\Actions\EventType\CloneEventTypeByIdAction;
use App\Actions\EventType\CloneEventTypeByIdRequest;
use App\Actions\EventType\DeleteEventTypeAction;
use App\Actions\EventType\DeleteEventTypeRequest;
use App\Actions\EventType\GetAvailableTimeAction;
use App\Actions\EventType\GetAvailableTimeRequest;
use App\Actions\EventType\GetEventTypeByIdAction;
use App\Actions\EventType\GetEventTypeByIdAndOwnerNicknameAction;
use App\Actions\EventType\GetEventTypeByIdAndOwnerNicknameRequest;
use App\Actions\EventType\GetEventTypeBySlugAndOwnerNicknameAction;
use App\Actions\EventType\GetEventTypeBySlugAndOwnerNicknameRequest;
use App\Actions\EventType\GetEventTypeCollectionAction;
use App\Actions\EventType\GetEventTypeCollectionByNicknameAction;
use App\Actions\EventType\GetEventTypeCollectionByNicknameRequest;
use App\Actions\EventType\GetEventTypeCollectionRequest;
use App\Actions\EventType\UpdateEventTypeAction;
use App\Actions\EventType\UpdateEventTypeRequest;
use App\Actions\EventType\UpdateInternalNoteByIdAction;
use App\Actions\EventType\UpdateInternalNoteByIdRequest;
use App\Actions\GetByIdRequest;
use App\Http\Presenters\AvailabilityServicePresenter;
use App\Http\Presenters\CustomFieldPresenter;
use App\Http\Presenters\EventTypePresenter;
use App\Http\Requests\Api\CustomField\CustomFieldRequest;
use App\Http\Requests\Api\EventType\ChangeDisabledEventTypeRequest;
use App\Http\Requests\Api\EventType\EventTypeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventTypeController extends ApiController
{
    private EventTypePresenter $eventTypePresenter;
    private AvailabilityServicePresenter $availabilityServicePresenter;
    private CustomFieldPresenter $customFieldPresenter;

    public function __construct(
        EventTypePresenter $eventTypePresenter,
        AvailabilityServicePresenter $availabilityServicePresenter,
        CustomFieldPresenter $customFieldPresenter
    ) {
        $this->eventTypePresenter = $eventTypePresenter;
        $this->availabilityServicePresenter = $availabilityServicePresenter;
        $this->customFieldPresenter = $customFieldPresenter;
    }

    public function index(Request $request, GetEventTypeCollectionAction $action)
    {
        $response = $action->execute(
            new GetEventTypeCollectionRequest(
                $request->searchString,
                (int)$request->query('page'),
                (int)$request->query('perPage'),
                $request->query('sorting'),
                $request->query('direction'),
                $request->query('all'),
            )
        );

        return $this->createPaginatedResponse(
            $response->getPaginator(),
            $this->eventTypePresenter
        );
    }

    public function store(EventTypeRequest $request, AddEventTypeAction $action): JsonResponse
    {
        $response = $action
            ->execute(new AddEventTypeRequest(
                $request->get('name'),
                $request->get('description'),
                $request->get('slug'),
                $request->get('color'),
                (int)$request->get('duration'),
                $request->get('timezone'),
                (bool)$request->get('disabled'),
                $request->get('availabilities'),
                $request->get('location_type'),
                $request->get('coordinates'),
                $request->get('address'),
                $request->get('chatito_workspace'),
                $request->get('tags')
            ))
            ->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($response), JsonResponse::HTTP_CREATED);
    }

    public function getEventTypeById(string $id, GetEventTypeByIdAction $action): JsonResponse
    {
        $eventType = $action
            ->execute(new GetByIdRequest((int)$id))
            ->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }

    public function update(string $id, EventTypeRequest $request, UpdateEventTypeAction $action): JsonResponse
    {
        $eventType = $action
            ->execute(
                new UpdateEventTypeRequest(
                    (int)$id,
                    $request->get('name'),
                    $request->get('description'),
                    $request->get('slug'),
                    $request->get('color'),
                    (int)$request->get('duration'),
                    $request->get('timezone'),
                    (bool)$request->get('disabled'),
                    $request->get('availabilities'),
                    $request->get('location_type'),
                    $request->get('coordinates'),
                    $request->get('address'),
                    $request->get('chatito_workspace'),
                    $request->get('tags')
                )
            )->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }

    public function destroy(string $id, DeleteEventTypeAction $action): JsonResponse
    {
        $action->execute(new DeleteEventTypeRequest((int)$id));

        return $this->emptyResponse();
    }

    public function changeDisabledById(
        string $id,
        ChangeDisabledEventTypeRequest $request,
        ChangeDisabledByIdAction $action
    ): JsonResponse {
        $action->execute(new ChangeDisabledByIdRequest(
            (int)$id,
            (bool)$request->disabled
        ));
        return $this->emptyResponse();
    }

    public function getAvailableTime(Request $request, GetAvailableTimeAction $action)
    {
        $dateTimeList = $action->execute(
            new GetAvailableTimeRequest(
                (int)$request->id,
                $request->month
            )
        )->getDateTimeList();

        return $this->successResponse($this->availabilityServicePresenter->presentArray($dateTimeList));
    }

    public function getEventTypesByNickname(
        string $nickname,
        GetEventTypeCollectionByNicknameAction $action
    ): JsonResponse {
        $response = $action->execute(
            new GetEventTypeCollectionByNicknameRequest($nickname)
        );

        $data = [
            'eventTypes' => $this->eventTypePresenter->presentCollection($response->getEventTypes()),
            'owner' => $response->getOwnerName()
        ];

        return $this->successResponse($data);
    }

    public function saveCustomFieldsByEventTypeId(
        CustomFieldRequest $request,
        AddCustomFieldsToEventTypeAction $action
    ) {
        $action->execute(
            new AddCustomFieldsToEventTypeRequest(
                (int)$request->id,
                $request->custom_fields,
                $request->to_delete_ids
            )
        );

        return $this->emptyResponse();
    }

    public function getCustomFieldsById(
        string $id,
        GetCustomFieldCollectionByEventTypeIdAction $action
    ): JsonResponse {
        $customFields = $action->execute(
            new GetCustomFieldCollectionByEventTypeIdRequest((int)$id)
        );

        return $this->successResponse(
            $this->customFieldPresenter->presentCollection(
                $customFields->getCustomFields()
            )
        );
    }

    public function cloneEventTypeById(
        string $id,
        CloneEventTypeByIdAction $action
    ): JsonResponse {
        $eventType = $action->execute(new CloneEventTypeByIdRequest(
            (int)$id
        ));

        return $this->successResponse($this->eventTypePresenter->present($eventType->getNewEventType()));
    }

    public function updateInternalNoteById(
        string $id,
        Request $request,
        UpdateInternalNoteByIdAction $action
    ): JsonResponse {
        $action->execute(new UpdateInternalNoteByIdRequest(
            (int)$id,
            $request->internal_note
        ));
        return $this->emptyResponse();
    }

    public function getEventTypeByIdAndNickname(
        Request $request,
        GetEventTypeByIdAndOwnerNicknameAction $action
    ): JsonResponse {
        $eventType = $action->execute(
            new GetEventTypeByIdAndOwnerNicknameRequest(
                (int)$request->id,
                $request->nickname
            )
        )->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }

    public function getEventTypeBySlugAndNickname(
        Request $request,
        GetEventTypeBySlugAndOwnerNicknameAction $action
    ): JsonResponse {
        $eventType = $action->execute(
            new GetEventTypeBySlugAndOwnerNicknameRequest(
                $request->slug,
                $request->nickname
            )
        )->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }
}
