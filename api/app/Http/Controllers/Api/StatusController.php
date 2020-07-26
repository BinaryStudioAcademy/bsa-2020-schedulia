<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Actions\Status\StatusAction;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
	private StatusAction $statusAction;

	public function __construct(StatusAction $statusAction)
	{
		$this->statusAction = $statusAction;
	}

	public function status(Request $request)
	{
		return response()->json(
			$this->statusAction->execute(
				$request->serviceName
			)->toArray(),
			200
		);
	} 
}
