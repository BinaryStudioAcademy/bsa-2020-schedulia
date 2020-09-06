<?php

namespace App\Http\Controllers\Zoom;

use App\Actions\Zoom\ZoomCallbackAction;
use App\Actions\Zoom\ZoomCallbackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    private $zoomCallbackAction;

    public function __construct(
        ZoomCallbackAction $zoomCallbackAction
    )
    {
        $this->zoomCallbackAction = $zoomCallbackAction;
    }

    public function handleCallback(Request $request)
    {
        $zoomRequest = new ZoomCallbackRequest(
            $request->get('code')
        );

        $this->zoomCallbackAction->execute($zoomRequest);

        return redirect(env('CLIENT_APP_URL', 'http://localhost:8080') . '/calendar-connections');
    }
}
