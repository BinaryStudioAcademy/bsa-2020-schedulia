<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch;

use App\Entity\Event;
use App\Repositories\BaseRepository;

final class ElasticSearchRepository extends BaseRepository implements ElasticSearchRepositoryInterface
{
    public function createIndex(array $data): void
    {
        \Elasticsearch::index($data);
    }

    public function update(array $data): void
    {
        \Elasticsearch::update($data);
    }

    public function delete(array $data): void
    {
        \Elasticsearch::delete($data);
    }

    public function search(array $data): object
    {
        return \Elasticsearch::search($data);
    }
}
