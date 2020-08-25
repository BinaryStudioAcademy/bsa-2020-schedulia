<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface PresenterCollectionInterface extends PresenterInterface
{
    public function presentCollection(Collection $collection): array;
}
