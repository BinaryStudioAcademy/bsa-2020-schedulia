<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use Illuminate\Support\Collection;

final class GetTagsByEventTypeIdResponse
{
    private Collection $tag;

    public function __construct(Collection $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): Collection
    {
        return $this->tag;
    }
}
