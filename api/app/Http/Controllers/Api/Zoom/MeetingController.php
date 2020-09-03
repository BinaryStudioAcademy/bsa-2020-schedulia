<?php

namespace App\Http\Controllers\Api\Zoom;

use App\Actions\Zoom\CreateMeetingAction;
use App\Actions\Zoom\CreateMeetingRequest;
use App\Actions\Zoom\ZoomCallbackAction;
use App\Actions\Zoom\ZoomCallbackRequest;
use App\Entity\Integration;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Zoom\MeetingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MeetingController extends Controller
{
    private $meetingAction;
    private $zoomCallbackAction;

    public function __construct(
        CreateMeetingAction $createMeetingAction,
        ZoomCallbackAction $zoomCallbackAction
    )
    {
        $this->meetingAction = $createMeetingAction;
        $this->zoomCallbackAction = $zoomCallbackAction;
    }

    public function create(MeetingRequest $request)
    {
        $createMeetingRequest = new  CreateMeetingRequest(
            $request->get('topic'),
            $request->get('start_time'),
            $request->get('agenda')
        );

        $response = $this->meetingAction->execute($createMeetingRequest);

        return $response;

//        return [
//        'success' => $response->status() === 201,
//        'data' => json_decode($response->body(), true),
//    ];
    }

    public function handleCallback(Request $request)
    {
        $zoomRequest = new ZoomCallbackRequest(
            $request->get('code')
        );

        $this->zoomCallbackAction->execute($zoomRequest);

    }
}
