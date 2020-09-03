<?php


namespace App\Repositories\Integrations;


use App\Entity\Integration;
use App\Exceptions\BaseException;
use App\Repositories\BaseRepository;

final class ZoomIntegrationRepository extends BaseRepository
{
    public function getAccessToken($id)
    {
        return Integration::find($id);
    }

    public function getInteraction()
    {
        return Integration::all();
    }

    public function updateToken($id, $token)
    {
        Integration::where('id', $id)->update(['access_token' => $token['access_token']]);
    }


}
