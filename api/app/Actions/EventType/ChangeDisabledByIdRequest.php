<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class ChangeDisabledByIdRequest
{
    private int $id;
    private bool $disabled;

    public function __construct(int $id, bool $disabled)
    {
        $this->id = $id;
        $this->disabled = $disabled;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDisabled(): bool
    {
        return $this->disabled;
    }
}
