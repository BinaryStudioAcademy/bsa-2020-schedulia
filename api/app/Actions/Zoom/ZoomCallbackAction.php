<?php

namespace App\Actions\Zoom;

use App\Services\Zoom\ZoomService;

final class ZoomCallbackAction
{
    private $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function execute(ZoomCallbackRequest $request)
    {
        $this->zoomService->saveToken($request->getCode());
    }
}
