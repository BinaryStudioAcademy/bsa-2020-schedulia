<?php

namespace App\Services\Zoom;

final class ZoomMeetingResponse
{
    private $zoomResponse;

    public function __construct($response)
    {
        $this->zoomResponse = $response;
    }

    public function getStartUrl()
    {
        $zoomResponseArr = json_decode($this->zoomResponse->body(), true);

        return $zoomResponseArr['start_url'];
    }
}
