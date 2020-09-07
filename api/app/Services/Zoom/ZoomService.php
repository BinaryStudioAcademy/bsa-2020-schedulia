<?php

namespace App\Services\Zoom;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Http;

final class ZoomService
{
    private const ZOOM_MEETING_API_ENDPOINT = 'https://api.zoom.us/v2/users/me/meetings';
    private const ZOOM_GET_USER_API_ENDPOINT = 'https://api.zoom.us/v2/users/me';
    private const ZOOM_OAUTH_TOKEN_POST_REQUEST_URL = 'https://zoom.us/oauth/token';

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function meeting($event)
    {
        $user = $this->userRepository->getById($event->eventType->owner_id);

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $user->zoom_access_token,
        ])->post(self::ZOOM_MEETING_API_ENDPOINT, [
            "topic" => $event->eventType->name,
            "start_time" => $event->start_date,
            "timezone" => $event->timezone
        ]);

        $zoomResponseArr = json_decode($response->body(), true);

        $event->zoom_meeting_link = $zoomResponseArr['start_url'];
        $event->save();
    }

    public function saveToken($request)
    {
        $token = $this->getZoomToken($request);
        $zoomUser = $this->getZoomUser($token);

        $user = $this->userRepository->getByEmail($zoomUser['email']);

        if ($user->zoom_access_token == null) {

            $user->zoom_access_token = $token['access_token'];
            $user->save();
        } else {
            $user->update(['zoom_access_token' => $token['access_token']]);
        }
    }

    public function getZoomUser($token)
    {
        $responseUser = Http::withHeaders([
            "Authorization" => "Bearer " . $token['access_token']
        ])->get(self::ZOOM_GET_USER_API_ENDPOINT);

        return json_decode($responseUser->body(), true);
    }

    public function getZoomToken($request)
    {
        $responseToken = Http::withHeaders([
            "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
        ])->asForm()->post(self::ZOOM_OAUTH_TOKEN_POST_REQUEST_URL, [
            "grant_type" => "authorization_code",
            "code" => $request->getCode(),
            "redirect_uri" => env('ZOOM_REDIRECT_URI')
        ]);

        return json_decode($responseToken->body(), true);
    }
}
