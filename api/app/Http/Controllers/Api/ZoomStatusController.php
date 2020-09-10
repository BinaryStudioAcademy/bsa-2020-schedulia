<?php

namespace App\Http\Controllers\Api;

use App\Actions\Zoom\ZoomChangeActivityAction;
use App\Actions\Zoom\ZoomChangeActivityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ZoomStatusController extends ApiController
{
    public function changeActivity(Request $request, ZoomChangeActivityAction $action)
    {
        $action->execute(new ZoomChangeActivityRequest((bool)$request->get('zoom_active')));

        return $this->emptyResponse();
    }
}
