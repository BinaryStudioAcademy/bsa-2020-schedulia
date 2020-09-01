<?php

declare(strict_types=1);

namespace App\Repositories\Tag;

use App\Entity\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function save(Tag $tag): Tag
    {
        $tag->save();

        return $tag;
    }

    public function findByCriteria(array $criteria): Collection
    {
        $query = Tag::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query
            ->select('tags.*')
            ->get();
    }
}
