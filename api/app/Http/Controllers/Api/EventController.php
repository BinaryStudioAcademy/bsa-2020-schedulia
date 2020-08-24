<?php

namespace App\Http\Controllers\Api;

use App\Actions\Event\AddEventAction;
use App\Actions\Event\AddEventRequest;
use App\Http\Requests\Api\Event\EventRequest;
use Illuminate\Http\Request;

class EventController extends ApiController
{
    private AddEventAction $addEventAction;

    public function __construct(AddEventAction $addEventAction)
    {
        $this->addEventAction = $addEventAction;
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
        //
    }
}
