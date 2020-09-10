<?php

namespace App\Actions\Zoom;

final class ZoomChangeActivityRequest
{
    private bool $zoomActivity;

    public function __construct(bool $zoomActivity)
    {
        $this->zoomActivity = $zoomActivity;
    }

     public function getZoomActivity():bool
     {
         return $this->zoomActivity;
     }
}
