<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Actions\Status\StatusAction;

class StatusController extends ApiController
{
    private StatusAction $statusAction;

    public function __construct(StatusAction $statusAction)
    {
        $this->statusAction = $statusAction;
    }

    public function status(Request $request)
    {
        return $this->successResponse(
            $this->statusAction->execute(
                $request->route('serviceName')
            )->toArray()
        );
    }
}
