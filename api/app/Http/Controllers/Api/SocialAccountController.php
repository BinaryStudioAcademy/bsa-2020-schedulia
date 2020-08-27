<?php

namespace App\Http\Controllers\Api;

use App\Actions\SocialAccount\AuthAction;
use App\Actions\SocialAccount\GetCalendarsCollectionAction;
use App\Actions\SocialAccount\GetCalendarsCollectionRequest;
use App\Entity\SocialAccount;
use App\Http\Presenters\SocialAccountArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAccountController extends ApiController
{
    private GetCalendarsCollectionAction $getCalendarsCollectionAction;
    private SocialAccountArrayPresenter $socialAccountArrayPresenter;

    public function __construct(
        GetCalendarsCollectionAction $getCalendarsCollectionAction,
        SocialAccountArrayPresenter $socialAccountArrayPresenter
    ) {
        $this->getCalendarsCollectionAction = $getCalendarsCollectionAction;
        $this->socialAccountArrayPresenter = $socialAccountArrayPresenter;
    }

    public function calendars(Request $request): JsonResponse
    {
        $response = $this->getCalendarsCollectionAction->execute(
            new GetCalendarsCollectionRequest(
                Auth::id(),
                [SocialAccount::GOOGLE_SERVICE_ID]
            )
        );

        return $this->successResponse($this->socialAccountArrayPresenter->presentCollection($response));
    }

    public function oauth(Request $request, AuthAction $action)
    {
        $provider = $request->route('provider');
        $response = $action->execute($provider, $request->input('code'));

        dd($response);

    }
}