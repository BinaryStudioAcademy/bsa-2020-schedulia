<?php

declare(strict_types=1);

namespace App\Actions\Chatito;

final class ChangeChatitoActivityRequest
{
    private bool $chatitoActivity;

    public function __construct(bool $chatitoActivity)
    {
        $this->chatitoActivity = $chatitoActivity;
    }

    public function getChatitoActivity(): bool
    {
        return $this->chatitoActivity;
    }
}
