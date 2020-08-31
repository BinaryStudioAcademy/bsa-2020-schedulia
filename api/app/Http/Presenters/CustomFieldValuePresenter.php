<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Entity\CustomFieldValue;
use Illuminate\Support\Collection;

final class CustomFieldValuePresenter
{
    public function presentCollection(Collection $customFieldValues)
    {
        return $customFieldValues->map(function ($customFieldValue) {
            return $this->present($customFieldValue);
        });
    }

    public function present(CustomFieldValue $customFieldValue)
    {
        return [
            'id' => $customFieldValue->id,
            'custom_field_id' => $customFieldValue->customField->id,
            'event_id' => $customFieldValue->event_id,
            'value' => $customFieldValue->value
        ];
    }
}
