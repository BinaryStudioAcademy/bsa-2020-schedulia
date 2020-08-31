<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class UpdateInternalNoteByIdRequest
{
    private int $id;
    private string $internalNote;

    public function __construct(int $id, string $internalNote)
    {
        $this->id = $id;
        $this->internalNote = $internalNote;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInternalNote(): string
    {
        return $this->internalNote;
    }
}
