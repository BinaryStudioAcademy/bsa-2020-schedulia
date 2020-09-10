<?php

namespace App\Http\Controllers\Api;

use App\Actions\Whale\WhaleChangeActivityAction;
use App\Actions\Whale\WhaleChangeActivityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhaleStatusController extends ApiController
{
    public function changeActivity(Request $request, WhaleChangeActivityAction $action)
    {
        $action->execute(new WhaleChangeActivityRequest((bool)$request->get('whale_active')));

        return $this->emptyResponse();
    }
}
