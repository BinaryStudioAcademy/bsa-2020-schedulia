<?php

declare(strict_types=1);

namespace App\Actions\SocialAccount;

use Illuminate\Support\Collection;

class AuthResponse
{
    private array $data;

    public function __construct(?AuthData ...$values)
    {
        $this->data = $values;
    }

    public function getAuthData(): Collection
    {
        return collect($this->parameters);
    }
}
