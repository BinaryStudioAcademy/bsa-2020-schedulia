<?php

namespace App\Http\Controllers\Api;

use App\Actions\Tag\AddTagAction;
use App\Actions\Tag\AddTagRequest;
use App\Actions\Tag\GetTagsByEventDateRangeAction;
use App\Actions\Tag\GetTagsByEventDateRangeRequest;
use App\Actions\Tag\GetTagsByEventTypeIdAction;
use App\Actions\Tag\GetTagsByEventTypeIdRequest;
use App\Http\Presenters\TagPresenter;
use App\Http\Requests\Api\Tag\TagRequest;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    private TagPresenter $presenter;

    public function __construct(TagPresenter $tagPresenter)
    {
        $this->presenter = $tagPresenter;
    }

    public function store(TagRequest $request, AddTagAction $addTagAction)
    {
        $response = $addTagAction->execute(
            new AddTagRequest(
                (int)$request->event_type_id,
                $request->name,
            )
        );

        return $this->successResponse(
            $this->presenter->present($response->getTag())
        );
    }

    public function getTagsByEventTypeId(
        Request $request,
        GetTagsByEventTypeIdAction $getTagsByEventTypeIdAction
    ) {
        $response = $getTagsByEventTypeIdAction->execute(
            new GetTagsByEventTypeIdRequest(
                $request->query('id')
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
