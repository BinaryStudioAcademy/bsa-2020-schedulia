<?php

namespace App\Http\Controllers\Api;

use App\Actions\SocialAccount\AuthAction;
use App\Entity\SocialAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialAccountController extends ApiController
{
    private GetCalendarsCollectionAction $getCalendarsCollectionAction;

    public function __construct(SocialAccountRepository $)
    {

    }

    public function calendars(Request $request)
    {
        $response = $this->calendars();
    }

    public function oauth(Request $request, AuthAction $action)
    {
        $provider = $request->route('provider');
        $response = $action->execute($provider, $request->input('code'));

        dd($response);

    }
}