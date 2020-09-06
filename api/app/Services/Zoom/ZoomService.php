<?php

namespace App\Services\Zoom;


use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class ZoomService
{
    private const ZOOM_MEETING_API_ENDPOINT = 'https://api.zoom.us/v2/users/me/meetings';
    private const ZOOM_GET_USER_API_ENDPOINT = 'https://api.zoom.us/v2/users/me';
    private const ZOOM_OAUTH_TOKEN_POST_REQUEST_URL = 'https://zoom.us/oauth/token';

    private $userRepository;
    private $zoomUserInfo;

    public function __construct(UserRepository $userRepository, ZoomUserInfo $zoomUserInfo)
    {
        $this->userRepository = $userRepository;
        $this->zoomUserInfo = $zoomUserInfo;
    }

    public function meeting($event)
    {
        $zoomUserEmail = $this->zoomUserInfo->getZoomUserEmail();

        $user = $this->userRepository->getByEmail($zoomUserEmail);

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $user->zoom_access_token,
        ])->post(self::ZOOM_MEETING_API_ENDPOINT,[
            "topic" => $event->eventType->name,
            "start_time" => $event->start_date,
            "timezone" => $event->timezone
        ]);

        $zoomMeetingResponse = new ZoomMeetingResponse($response);

        return $zoomMeetingResponse->getStartUrl();
    }

    public function saveToken($request)
    {
        $token = $this->getZoomToken($request);
        $zoomUser = $this->getZoomUser($token);

        $this->zoomUserInfo->setZoomUserEmail($zoomUser['email']);

        $user = $this->userRepository->getByEmail($zoomUser['email']);

        if (!$user) {
            $this->createUser($zoomUser);
        }

        if ($user->zoom_access_token == null) {

            $user->zoom_access_token = $token['access_token'];
            $user->save();
        } else {
            $user->update([$user->zoom_access_token = $token['access_token']]);
        }
    }

    public function createUser($zoomUser)
    {
        $user = new User();
        $user->name = $zoomUser['first_name'] .' '.$zoomUser['last_name'] ;
        $user->email = $zoomUser['email'];
        $user->email_verified_at = now();
        $user->password = Hash::make(Str::random(40));

        $user = $this->userRepository->save($user);
    }

    public function getZoomUser($token)
    {
        $responseUser = Http::withHeaders([
            "Authorization" => "Bearer ". $token['access_token']
        ])->get(self::ZOOM_GET_USER_API_ENDPOINT);

        return json_decode($responseUser->body(),true);
    }

    public function getZoomToken($request)
    {
        $responseToken = Http::withHeaders([
            "Authorization" => "Basic ". base64_encode('TqOhSFl3THurYIMqbrR58Q'.':'. 'rjzv7lpqebwLoBTQF7FPpkuSIGBiDpdF')
        ])->asForm()->post(self::ZOOM_OAUTH_TOKEN_POST_REQUEST_URL, [
            "grant_type" => "authorization_code",
            "code" => $request->getCode(),
            "redirect_uri" => 'https://f39ac760c645.ngrok.io/meetings/zoom/callback'
        ]);

        return json_decode($responseToken->body(), true);
    }
}
