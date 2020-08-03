<?php

declare(strict_types=1);

namespace App\Actions\Status;

use Illuminate\Support\Collection;

class StatusResponse
{
    private array $parameters;

    public function __construct(?StatusParameter ...$values)
    {
        $this->parameters = $values;
    }

    public function getStatusParameters(): Collection
    {
        return collect($this->parameters);
    }
}
