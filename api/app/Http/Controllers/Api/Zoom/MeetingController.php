<?php

namespace App\Http\Controllers\Api\Zoom;

use App\Actions\Zoom\CreateMeetingAction;
use App\Actions\Zoom\CreateMeetingRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Zoom\MeetingRequest;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    private $meetingAction;

    public function __construct(CreateMeetingAction $createMeetingAction)
    {
        $this->mettingAction = $createMeetingAction;
    }

    public function create(MeetingRequest $request)
    {
//        $createMeetingRequest = new  CreateMeetingRequest(
//            $request->get('topic'),
//            $request->get('start_time'),
//            $request->get('agenda')
//        );

        $response = $this->meetingAction->execute();

        return response()->json($response);
    }
}
