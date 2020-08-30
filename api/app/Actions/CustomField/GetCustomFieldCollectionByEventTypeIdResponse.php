<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

use Illuminate\Support\Collection;

final class GetCustomFieldCollectionByEventTypeIdResponse
{
    private Collection $customFields;

    public function __construct(Collection $customFields)
    {
        $this->customFields = $customFields;
    }

    public function getCustomFields(): Collection
    {
        return $this->customFields;
    }
}
