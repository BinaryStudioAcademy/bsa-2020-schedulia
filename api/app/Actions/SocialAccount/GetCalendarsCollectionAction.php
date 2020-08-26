<?php

namespace App\Actions\SocialAccount;


final class GetCalendarsCollectionAction
{
    private SocialAccountRepositoryInterface $socialAccountRepository;

    public function __construct(SocialAccountRepositoryInterface $socialAccountRepository)
    {
        $this->socialAccountRepository = $socialAccountRepository;
    }

    public function execute()
    {
        
    }
}