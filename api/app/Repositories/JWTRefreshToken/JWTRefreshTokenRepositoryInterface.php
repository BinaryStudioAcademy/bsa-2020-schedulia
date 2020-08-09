<?php

declare(strict_types=1);

namespace App\Repositories\JWTRefreshToken;

use App\Entity\JWTRefreshToken;

interface JWTRefreshTokenRepositoryInterface
{
    public function getById(int $id): ?JWTRefreshToken;
    public function save(JWTRefreshToken $JWTRefreshToken): JWTRefreshToken;
    public function deleteById(int $id): void;
}
