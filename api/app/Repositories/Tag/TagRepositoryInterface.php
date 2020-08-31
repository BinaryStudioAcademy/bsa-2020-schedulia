<?php

namespace App\Repositories\Tag;

use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function findByCriteria(array $criteria): Collection;
}
