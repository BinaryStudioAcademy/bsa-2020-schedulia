<?php

declare(strict_types=1);

namespace App\Actions\RoutersTester;

class CheckNicknameSlugRequest
{
    private string $nickname;
    private string $slug;

    public function __construct(string $nickname, string $slug)
    {
        $this->nickname = $nickname;
        $this->slug = $slug;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

}
