<?php

declare(strict_types=1);

namespace App\Repositories\CustomField;

use App\Entity\CustomField;

final class CustomFieldRepository
{
    public function getById(int $id)
    {
        return CustomField::find($id);
    }

    public function save(CustomField $customField)
    {
        $customField->save();
    }

    public function delete(CustomField $customField)
    {
        $customField->delete();
    }

    public function deleteForEventType(CustomField $customField)
    {
        $customField->event_type_id = null;
        $this->save($customField);
    }
}
