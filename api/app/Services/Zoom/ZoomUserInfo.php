<?php

namespace App\Services\Zoom;

final class ZoomUserInfo
{
    private $email;

    public function getZoomUserEmail()
    {
        return $this->email;
    }

    public function setZoomUserEmail($email)
    {
        $this->email = $email;
    }
}
