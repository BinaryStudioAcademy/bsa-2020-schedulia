<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Entity\Availability;

final class AvailabilityArrayPresenter
{
    public function present(Availability $availability): array
    {
        return [
            'type' => $availability->type,
            'start_date' => $availability->start_date,
            'end_date' => $availability->end_date,
        ];
    }
}
