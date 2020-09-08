<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

use App\Entity\CustomField;
use App\Repositories\CustomField\CustomFieldRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;

final class AddCustomFieldsToEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;
    private CustomFieldRepository $customFieldRepository;

    public function __construct(
        EventTypeRepositoryInterface $eventTypeRepository,
        CustomFieldRepository $customFieldRepository
    ) {
        $this->eventTypeRepository = $eventTypeRepository;
        $this->customFieldRepository = $customFieldRepository;
    }

    public function execute(AddCustomFieldsToEventTypeRequest $request): void
    {
        $eventType = $this->eventTypeRepository->getById($request->getEventTypeId());

        foreach ($request->getCustomFields() as $customField) {
            $customFieldModel = $this->customFieldRepository->getById((int)$customField['id']);
            if ($customFieldModel) {
                $customFieldModel->name = $customField['name'];
                $customFieldModel->type = $customField['type'];
                $this->customFieldRepository->save($customFieldModel);
            } else {
                $this->customFieldRepository->save(
                    new CustomField([
                        'event_type_id' => $eventType->id,
                        'type' => $customField['type'],
                        'name' => $customField['name']
                    ])
                );
            }
        }
        if (!empty($request->getToDeleteIds())) {
            foreach ($request->getToDeleteIds() as $customFieldId) {
                $customFieldModelToDelete = $this->customFieldRepository->getById((int)$customFieldId);
                if (!is_null($customFieldModelToDelete)) {
                    $this->customFieldRepository->deleteForEventType($customFieldModelToDelete);
                }
            }
        }
    }
}
