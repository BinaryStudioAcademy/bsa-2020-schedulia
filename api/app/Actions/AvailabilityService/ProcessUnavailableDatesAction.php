<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

use App\Services\Availability\AvailabilityTypes;

final class ProcessUnavailableDatesAction
{
    public function execute(ModificateDateTimeListRequest $request)
    {
        $dateTimeList = $request->getDateTimeList();
        foreach ($dateTimeList as $date => $intervals) {
            foreach ($intervals as $index => $interval) {
                if ($dateTimeList[$date][$index]['type'] === AvailabilityTypes::UNAVAILABLE) {
                    $dateTimeList[$date] = [];
                }
            }
        }
        return new ModificateDateTimeListResponse($dateTimeList);
    }
}
