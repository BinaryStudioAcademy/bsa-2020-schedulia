<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Slack\AddSlackNotificationsAction;
use App\Actions\Slack\AddSlackNotificationsRequest;
use App\Actions\Slack\ChangeActivitySlackNotificationsAction;
use App\Actions\Slack\DeleteSlackNotificationsAction;
use App\Http\Requests\Api\Slack\SlackRequest;
use Illuminate\Http\JsonResponse;

class SlackController extends ApiController
{
    public function addSlackNotifications(
        SlackRequest $request,
        AddSlackNotificationsAction $action
    ): JsonResponse{
        $action->execute(new AddSlackNotificationsRequest(
            $request->incoming_webhook,
            $request->channel_name
        ));

        return $this->emptyResponse();
    }

    public function deleteSlackNotifications(DeleteSlackNotificationsAction $action): JsonResponse
    {
        $action->execute();
        return $this->emptyResponse();
    }

    public function changeActivitySlackNotifications(ChangeActivitySlackNotificationsAction $action): JsonResponse
    {
        $action->execute();
        return $this->emptyResponse();
    }
}
