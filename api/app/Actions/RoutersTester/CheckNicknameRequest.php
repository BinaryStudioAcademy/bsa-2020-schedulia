<?php

declare(strict_types=1);

namespace App\Actions\RoutersTester;

class CheckNicknameRequest
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $this->nickname = $nickname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

}
