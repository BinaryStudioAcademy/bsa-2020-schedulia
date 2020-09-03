<?php

declare(strict_types=1);

namespace App\Actions\SocialAccount;

use App\Services\SocialAccount\Google;

final class DeleteCalendarAccountAction
{
    private Google $google;

    public function __construct(
        Google $google
    ) {
        $this->google = $google;
    }

    public function execute(DeleteCalendarRequest $request): void
    {
        $provider = $request->getProvider();
        $this->$provider->delete($request->getUserId());
    }
}
