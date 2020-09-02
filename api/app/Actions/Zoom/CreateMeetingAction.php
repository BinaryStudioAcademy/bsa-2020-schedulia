<?php

namespace App\Actions\Zoom;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

final class CreateMeetingAction
{

    public function execute()
    {
        $path = 'users/univer1857@gmail.com/meetings';

        $meeting = $this->zoomPost($path, [
            'topic' => 'test',
            'start_time' => '2020-09-03T12:02:00Z',
            'agenda' => 'test description',
            'duration' => 30

        ]);

        return $meeting;
    }

    private function zoomPost(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->post($url . $path, $body);
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL');
    }

    private function zoomRequest()
    {
        $jwt = $this->generateZoomToken();
        return Http::withHeaders([
            'authorization' => 'Bearer ' . $jwt,
            'content-type' => 'application/json',
        ]);
    }

    private function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY');
        $secret = env('ZOOM_API_SECRET');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        return JWT::encode($payload, $secret, 'HS256');
    }
}
