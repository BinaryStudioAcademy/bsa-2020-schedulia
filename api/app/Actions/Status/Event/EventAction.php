<?php

declare(strict_types=1);

namespace App\Actions\Status\Event;

use App\Events\TestEvent;

class EventAction
{
    public function execute(EventRequest $request): void
    {
        event(new TestEvent($request->getMessage()));
    }
}
