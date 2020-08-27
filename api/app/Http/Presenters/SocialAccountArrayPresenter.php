<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterInterface;
use App\Entity\SocialAccount;
use Illuminate\Support\Collection;

final class SocialAccountArrayPresenter implements PresenterInterface
{
    public function present(SocialAccount $socialAccount): array
    {
        return [
            'provider' => $socialAccount->provider_text,
            'account_id' => $socialAccount->account_id
        ];
    }

    public function presentCollection(Collection $socialAccountCollection): array
    {
        return $socialAccountCollection->map(function ($socialAccount) {
            return $this->present($socialAccount);
        })->toArray();
    }
}
