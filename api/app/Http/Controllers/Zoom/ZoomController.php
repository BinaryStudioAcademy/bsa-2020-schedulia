<?php

namespace App\Http\Controllers\Zoom;

use App\Actions\Zoom\ZoomCallbackAction;
use App\Actions\Zoom\ZoomCallbackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomController extends Controller
{
    private ZoomCallbackAction $zoomCallbackAction;

    public function __construct(
        ZoomCallbackAction $zoomCallbackAction
    ) {
        $this->zoomCallbackAction = $zoomCallbackAction;
    }

    public function redirectToZoom(Request $request)
    {
        return redirect('https://zoom.us/oauth/authorize?response_type=code&client_id=' . env('ZOOM_CLIENT_ID') . '&redirect_uri=' . env('ZOOM_REDIRECT_URI') . "&state={$request->get('user')}");
    }

    public function handleCallback(Request $request)
    {
        $zoomRequest = new ZoomCallbackRequest(
            $request->get('code'),
            $request->get('state')
        );

        $this->zoomCallbackAction->execute($zoomRequest);

        return redirect(env('CLIENT_APP_URL', 'http://localhost:8080') . '/calendar-connections');
    }
}
