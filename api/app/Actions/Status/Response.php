<?php

namespace App\Actions\Status;

class Response
{
	private string $app;
	private string $server;
	private string $database;
	private string $redis;
	private string $storageInfo;

	public function __construct(
		string $app,
		string $server,
		string $database,
		string $redis,
		string $storageInfo
	) {
		$this->app = $app;
		$this->server = $server;
		$this->database = $database;
		$this->redis = $redis;
		$this->storageInfo = $storageInfo;
	}

	public function toArray(): array
	{
		return [
			"app" => $this->app,
			"server" => $this->server,
			"database" => $this->database,
			"redis" => $this->redis,
			"storage" => $this->storageInfo,
		];
	}
}
