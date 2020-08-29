<?php

namespace App\Repositories\ElasticSearch;

use App\Entity\Event;

interface ElasticSearchRepositoryInterface
{
    public function createIndex(array $data): void;
    public function search(array $data): Object;
    public function update(array $data): void;
    public function delete(array $data): void;
}
