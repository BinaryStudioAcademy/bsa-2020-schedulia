<?php

declare(strict_types=1);

namespace App\Repositories\JWTRefreshToken;

use App\Entity\JWTRefreshToken;
use App\Repositories\BaseRepository;

final class JWTRefreshTokenRepository extends BaseRepository implements JWTRefreshTokenRepositoryInterface
{
    public function getByUserId(int $userId): ?JWTRefreshToken
    {
        return JWTRefreshToken::firstWhere('user_id', $userId);
    }

    public function save(JWTRefreshToken $JWTRefreshToken): JWTRefreshToken
    {
        $JWTRefreshToken->save();

        return $JWTRefreshToken;
    }

    public function deleteById(int $id): void
    {
        JWTRefreshToken::destroy($id);
    }
}
