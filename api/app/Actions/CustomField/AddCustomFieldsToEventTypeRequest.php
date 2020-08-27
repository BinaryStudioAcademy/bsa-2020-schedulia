<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

final class AddCustomFieldsToEventTypeRequest
{
    private array $customFields;

    public function __construct(array $customFields) {
        $this->customFields = $customFields;
    }

    public function getCustomFields(): array
    {
        return $this->customFields;
    }
}
