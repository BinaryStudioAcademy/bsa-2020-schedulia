<?php

namespace App\Services\Whale;

use App\Entity\Event;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Http;

final class WhaleService
{
    private const WHALE_MEETING_API_ENDPOINT = 'https://bsa2020-whale.westeurope.cloudapp.azure.com/api/external/startMeeting';

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function meeting(Event $event): string
    {
        $user = $this->userRepository->getById($event->eventType->owner_id);

        $whaleResponse = Http::post(self::WHALE_MEETING_API_ENDPOINT, [
            "email" => $user->email
        ]);

        $whaleResponseArr = json_decode($whaleResponse->body(), true);

        return $whaleResponseArr['url'];
    }
}
