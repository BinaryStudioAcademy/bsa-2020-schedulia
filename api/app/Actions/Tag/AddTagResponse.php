<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use App\Entity\Tag;

final class AddTagResponse
{
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }
}
