<?php

namespace App\Actions\Whale;

final class WhaleChangeActivityRequest
{
    private bool $whaleActivity;

    public function __construct(bool $whaleActivity)
    {
        $this->whaleActivity = $whaleActivity;
    }

    public function getWhaleActivity(): bool
    {
        return $this->whaleActivity;
    }
}
