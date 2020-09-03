<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Contracts\EloquentCriterion;
use App\Entity\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getById(int $id): ?User;
    public function getByEmail(string $email): ?User;
    public function save(User $user): User;
    public function deleteById(int $id): void;
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
    public function findOneByCriteria(EloquentCriterion ...$criteria): ?User;
}
