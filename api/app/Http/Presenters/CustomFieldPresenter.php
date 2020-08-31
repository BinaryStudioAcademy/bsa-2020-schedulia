<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Entity\CustomField;
use Illuminate\Support\Collection;

final class CustomFieldPresenter
{
    public function presentCollection(Collection $customFieldValues): array
    {
        return $customFieldValues->map(function ($customFieldValue) {
            return $this->present($customFieldValue);
        })->toArray();
    }

    public function present(CustomField $customFieldValue): array
    {
        return [
            'id' => $customFieldValue->id,
            'event_type_id' => $customFieldValue->eventType->id,
            'type' => $customFieldValue->type,
            'name' => $customFieldValue->name
        ];
    }
}
