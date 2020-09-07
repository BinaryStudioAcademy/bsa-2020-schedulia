<?php

namespace App\Http\Controllers\Zoom;

use App\Actions\Zoom\ZoomCallbackAction;
use App\Actions\Zoom\ZoomCallbackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    private ZoomCallbackAction $zoomCallbackAction;

    public function __construct(
        ZoomCallbackAction $zoomCallbackAction
    ) {
        $this->zoomCallbackAction = $zoomCallbackAction;
    }

    public function redirectToZoom()
    {
        return redirect('https://zoom.us/oauth/authorize?response_type=code&client_id=' . env('ZOOM_CLIENT_ID') . '&redirect_uri=' . env('ZOOM_REDIRECT_URI'));
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
