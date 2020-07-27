<?php

namespace App\Actions\Status;

class Response
{
    private array $data;

    public function __construct(?Parameter ...$values)
    {
        $this->data = $values;
    }

    public function add(Parameter $parameter): void
    {
        $this->data[] = $parameter;
    }

    public function toArray(): array
    {
        return collect($this->data)->map(
            fn(Parameter $parameter) => $parameter->toArray()
        )->toArray();
    }
}
