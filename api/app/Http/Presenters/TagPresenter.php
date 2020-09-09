<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use App\Entity\Tag;
use Illuminate\Support\Collection;

final class TagPresenter implements PresenterCollectionInterface
{
    public function present(Tag $tag): array
    {
        return [
            'name' => $tag->name,
        ];
    }

    public function presentCollection(Collection $eventCollection): array
    {
        return $eventCollection->map(function ($tag) {
            return $this->present($tag);
        })->toArray();
    }
}
