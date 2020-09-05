<?php

namespace App\Actions\Zoom;

final class CreateMeetingResponse
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
