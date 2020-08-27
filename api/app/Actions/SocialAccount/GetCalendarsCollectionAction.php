<?php

namespace App\Actions\SocialAccount;


use App\Repositories\SocialAccount\Criterion\ProviderCriterion;
use App\Repositories\SocialAccount\Criterion\UserCriterion;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;

final class GetCalendarsCollectionAction
{
    private SocialAccountRepositoryInterface $socialAccountRepository;

    public function __construct(SocialAccountRepositoryInterface $socialAccountRepository)
    {
        $this->socialAccountRepository = $socialAccountRepository;
    }

    public function execute(GetCalendarsCollectionRequest $request)
    {
        $criteria = [new UserCriterion($request->getUserId())];

        if($request->getProviders())
        {
            $criteria[] = new ProviderCriterion($request->getProviders());
        }

        $response = $this->socialAccountRepository->findByCriteria(...$criteria);

        return $response;
    }
}