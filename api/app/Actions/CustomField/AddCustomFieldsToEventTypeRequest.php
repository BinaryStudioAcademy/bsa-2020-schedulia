<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

final class AddCustomFieldsToEventTypeRequest
{
    private int $eventTypeId;
    private array $customFields;
    private ?array $toDeleteIds;

    public function __construct(int $eventTypeId, array $customFields, ?array $toDeleteIds)
    {
        $this->eventTypeId = $eventTypeId;
        $this->customFields = $customFields;
        $this->toDeleteIds = $toDeleteIds;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    public function getToDeleteIds(): ?array
    {
        return $this->toDeleteIds;
    }
}
