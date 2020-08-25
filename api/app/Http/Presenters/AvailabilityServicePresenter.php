<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterInterface;

final class AvailabilityServicePresenter implements PresenterInterface
{
    public function presentArray(array $dateTimeList): array
    {
        return array_map(function ($date) {
            return array_map(function ($interval) {
                return $this->present($interval);
            }, $date);
        }, $dateTimeList);
    }

    public function present(array $dateTimeInterval): array
    {
        return [
            'type' => $dateTimeInterval['type'],
            'start_time' => $dateTimeInterval['start_time'],
            'end_time' => $dateTimeInterval['end_time'],
            'unavailable' => $dateTimeInterval['unavailable']
        ];
    }
}
