<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Entity\EventType;

final class ChangeDisabledByIdAction
{
    public function execute(ChangeDisabledByIdRequest $request): void
    {
        $eventType = EventType::find($request->getId());
        $eventType->disabled = $request->getDisabled();
        $eventType->save();
    }
}
