<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

final class UpdateCustomFieldsToEventTypeRequest
{
    private int $eventTypeId;
    private array $customFields;

    public function __construct(int $eventTypeId, array $customFields) {
        $this->eventTypeId = $eventTypeId;
        $this->customFields = $customFields;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getCustomFields(): array
    {
        return $this->customFields;
    }
}
