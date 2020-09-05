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

    public function execute($event)
    {
        $integration = $this->integrationRepository->getInteraction();

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $integration->access_token,
        ])->post('https://api.zoom.us/v2/users/me/meetings',[
            "topic" => $event->eventType->name,
            "start_time" => $event->start_date,
            "timezone" => $event->timezone
        ]);

        $createMeetingResponse = new CreateMeetingResponse($response);

        return $createMeetingResponse->getStartUrl();
    }
}
