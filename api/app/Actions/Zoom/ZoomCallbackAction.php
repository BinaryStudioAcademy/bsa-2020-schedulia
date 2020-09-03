<?php


namespace App\Actions\Zoom;


use App\Entity\Integration;
use App\Repositories\Integrations\ZoomIntegrationRepository;
use Illuminate\Support\Facades\Http;

final class ZoomCallbackAction
{
    private $interactionRepository;

    public function __construct(ZoomIntegrationRepository $integrationRepository)
    {
        $this->interactionRepository = $integrationRepository;
    }

    public function execute(ZoomCallbackRequest $request)
    {
        $response = Http::withHeaders([
            "Authorization" => "Basic ". base64_encode(env('ZOOM_CLIENT_ID').':'. env('ZOOM_CLIENT_SECRET'))
        ])->asForm()->post('https://zoom.us/oauth/token', [
            "grant_type" => "authorization_code",
            "code" => $request->getCode(),
            "redirect_uri" => env('ZOOM_REDIRECT_URI')
        ]);

        $token = json_decode($response->body(), true);

        $integration = $this->interactionRepository->getInteraction();

        if ($integration->isEmpty()) {
            $integration = new Integration([
                'access_token' => $token['access_token']
            ]);
            $integration->save();
        } else {
            $this->interactionRepository->updateToken(1, $token);
        }
    }
}
