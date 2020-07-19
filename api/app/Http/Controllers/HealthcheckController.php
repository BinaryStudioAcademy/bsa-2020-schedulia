<?php

namespace App\Http\Controllers;

use App\Actions\Healthcheck\HealthcheckAction;

class HealthcheckController extends Controller
{
	private HealthcheckAction $healthcheckAction;

	public function __construct(HealthcheckAction $healthcheckAction)
	{
		$this->healthcheckAction = $healthcheckAction;
	}

	public function healthcheck()
	{
		return response()->json(
			$this->healthcheckAction->execute()->toArray(),
			200
		);
	} 
}
