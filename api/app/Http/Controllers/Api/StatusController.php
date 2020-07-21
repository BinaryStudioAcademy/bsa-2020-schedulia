<?php

namespace App\Http\Controllers\Api;

use App\Actions\Status\StatusAction;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
	private StatusAction $statusAction;

	public function __construct(StatusAction $statusAction)
	{
		$this->statusAction = $statusAction;
	}

	public function Status()
	{
		return response()->json(
			$this->statusAction->execute()->toArray(),
			200
		);
	} 
}
