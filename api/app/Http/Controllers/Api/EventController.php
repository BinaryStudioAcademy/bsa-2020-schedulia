<?php

namespace App\Http\Controllers\Api;

use App\Actions\Event\AddEventAction;
use App\Actions\Event\AddEventRequest;
use App\Actions\Event\GetEventCollectionAction;
use App\Actions\Event\GetEventCollectionRequest;
use App\Http\Presenters\EventPresenter;
use App\Http\Requests\Api\Event\EventRequest;
use Illuminate\Http\Request;

class EventController extends ApiController
{
    private AddEventAction $addEventAction;
    private GetEventCollectionAction $getEventCollectionAction;
    private $presenter;

    public function __construct
    (
        AddEventAction $addEventAction,
        GetEventCollectionAction $getEventCollectionAction,
        EventPresenter $eventPresenter
    )
    {
        $this->addEventAction = $addEventAction;
        $this->getEventCollectionAction = $getEventCollectionAction;
        $this->presenter = $eventPresenter;
    }

    public function store(EventRequest $request)
    {
        $this->addEventAction->execute(
            new AddEventRequest(
                (int)$request->event_type_id,
                $request->invitee_name,
                $request->invitee_email,
                $request->start_date,
                $request->timezone,
            )
        );

        return $this->emptyResponse();
    }

    public function index(Request $request)
    {
        $response = $this->getEventCollectionAction->execute(
            new GetEventCollectionRequest(
                $request->query('startDate'),
                $request->query('endDate'),
                (int)$request->query('page'),
                (int)$request->query('perPage'),
                $request->query('sort'),
                $request->query('direction')
            )
        );

        return $this->createPaginatedResponse(
            $response->getPaginator(),
            $this->presenter
        );
    }
}
