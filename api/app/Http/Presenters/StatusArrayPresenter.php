<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\Status\StatusParameter;
use Illuminate\Support\Collection;

final class StatusArrayPresenter
{
    public function present(StatusParameter $statusParameter): array
    {
        return [
            'name' => $statusParameter->getName(),
            'value' => $statusParameter->getValue()
        ];
    }

    public function presentCollection(Collection $statusParameters): array
    {
        return $statusParameters->map(fn (StatusParameter $parameter) => $this->present($parameter))->all();
    }
}
