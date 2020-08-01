<?php

namespace App\Actions\Status;

class StatusResponse
{
    private array $data;

    public function __construct(?StatusParameter ...$values)
    {
        $this->data = $values;
    }

    public function add(StatusParameter $parameter): void
    {
        $this->data[] = $parameter;
    }

    public function toArray(): array
    {
        return collect($this->data)->map(
            fn (StatusParameter $parameter) => $parameter->toArray()
        )->toArray();
    }
}
