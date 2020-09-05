<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Chatito\ChangeChatitoActivityAction;

use App\Actions\Chatito\ChangeChatitoActivityRequest;
use App\Http\Requests\Api\Chatito\ChangeActivityRequest;
use Illuminate\Http\JsonResponse;

class ChatitoController extends ApiController
{
    public function changeActivity(
        ChangeActivityRequest $request,
        ChangeChatitoActivityAction $action
    ): JsonResponse {
        $action->execute(new ChangeChatitoActivityRequest(
            (bool)$request->chatito_active
        ));

        return $this->emptyResponse();
    }
}
