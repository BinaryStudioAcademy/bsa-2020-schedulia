<?php

namespace App\Repositories\Tag;

use App\Entity\Tag;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function save(Tag $tag): Tag;
    public function findByCriteria(array $criteria): Collection;
}
