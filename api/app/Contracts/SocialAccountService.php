<?php

declare(strict_types=1);

namespace App\Contracts;

interface SocialAccountService
{
    public function auth();
    public function delete(int $userId): void;
}
