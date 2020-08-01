<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Actions\Status\StatusAction;

class StatusController extends ApiController
{
    public function status(Request $request, StatusAction $action)
    {
        return $this->successResponse(
            $action->execute(
                $request->route('serviceName')
            )->toArray()
        );
    }
}
