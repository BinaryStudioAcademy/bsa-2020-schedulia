<?php

namespace App\Http\Controllers\Api;

use App\Actions\SocialAccount\AuthAction;
use App\Actions\SocialAccount\DeleteCalendarAccountAction;
use App\Actions\SocialAccount\DeleteCalendarRequest;
use App\Actions\SocialAccount\GetCalendarsCollectionAction;
use App\Actions\SocialAccount\GetCalendarsCollectionRequest;
use App\Entity\SocialAccount;
use App\Http\Presenters\GoogleResponseArrayPresenter;
use App\Http\Presenters\SocialAccountArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SocialAccountController extends ApiController
{
    private AuthAction $authAction;
    private GetCalendarsCollectionAction $getCalendarsCollectionAction;
    private SocialAccountArrayPresenter $socialAccountArrayPresenter;
    private GoogleResponseArrayPresenter $googleResponseArrayPresenter;

    public function __construct(
        GetCalendarsCollectionAction $getCalendarsCollectionAction,
        AuthAction $authAction,
        DeleteCalendarAccountAction $deleteCalendarAccountAction,
        SocialAccountArrayPresenter $socialAccountArrayPresenter,
        GoogleResponseArrayPresenter $googleResponseArrayPresenter
    ) {
        $this->getCalendarsCollectionAction = $getCalendarsCollectionAction;
        $this->socialAccountArrayPresenter = $socialAccountArrayPresenter;
        $this->googleResponseArrayPresenter = $googleResponseArrayPresenter;
        $this->authAction = $authAction;
        $this->deleteCalendarAccountAction = $deleteCalendarAccountAction;
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

    public function destroyCalendar(Request $request): JsonResponse
    {
        $provider = $request->route('provider');
        $this->deleteCalendarAccountAction->execute(new DeleteCalendarRequest(Auth::id(), $provider));

        return $this->emptyResponse();
    }

    public function oauth(Request $request): JsonResponse
    {
        $provider = $request->route('provider');
        $response = $this->authAction->execute($provider);

        return $this->successResponse($this->googleResponseArrayPresenter->present($response));
    }

    public function oauthResponse(Request $request)
    {
        $provider = $request->route('provider');
        $response = $this->authAction->execute($provider, $request->input('code'), $request->input('state'));

        return Redirect::away($response->getUrl());
    }
}
