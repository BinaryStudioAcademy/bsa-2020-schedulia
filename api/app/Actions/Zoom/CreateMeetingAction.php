<?php

namespace App\Actions\Zoom;

use App\Repositories\Integrations\ZoomIntegrationRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

final class CreateMeetingAction
{
    private $integrationRepository;

    public function __construct(ZoomIntegrationRepository $integrationRepository)
    {
        $this->integrationRepository = $integrationRepository;
    }

    public function execute($startTime, $eventName)
    {
        $integration = $this->integrationRepository->getAccessToken(1);

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $integration->access_token,
        ])->post('https://api.zoom.us/v2/users/me/meetings',[
            "topic" => $eventName,
            "start_time" => $startTime,
        ]);

        $response = json_decode($response->body(), true);

        return $response['start_url'];
    }
}
