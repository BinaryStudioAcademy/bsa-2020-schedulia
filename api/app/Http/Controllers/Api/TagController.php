<?php

namespace App\Http\Controllers\Api;

use App\Actions\Tag\GetTagsByEventDateRangeAction;
use App\Actions\Tag\GetTagsByEventDateRangeRequest;
use App\Actions\Tag\GetTagsByEventTypeIdAction;
use App\Actions\Tag\GetTagsByEventTypeIdRequest;
use App\Http\Presenters\TagPresenter;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    private $presenter;

    public function __construct(TagPresenter $tagPresenter)
    {
        $this->presenter = $tagPresenter;
    }

    public function getTagsByEventTypeId(
        Request $request,
        GetTagsByEventTypeIdAction $getTagsByEventTypeIdAction
    ) {
        $response = $getTagsByEventTypeIdAction->execute(
            new GetTagsByEventTypeIdRequest(
                $request->query('event_types_id')
            )
        );

        return $this->successResponse(
            $this->presenter->presentCollection($response->getTag())
        );
    }

    public function getTagsByEventDateRange(
        Request $request,
        GetTagsByEventDateRangeAction $getTagsByEventDateRangeAction
    ) {
        $response = $getTagsByEventDateRangeAction->execute(
            new GetTagsByEventDateRangeRequest(
                $request->query('start_date'),
                $request->query('end_date')
            )
        );

        return $this->successResponse(
            $this->presenter->presentCollection($response->getTag())
        );
    }
}
