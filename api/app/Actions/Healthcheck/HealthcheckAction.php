<?php

namespace App\Actions\Healthcheck;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Filesystem\Filesystem;

class HealthcheckAction
{
	private Cache $cache;
	private Filesystem $fs;

	public function __construct(Cache $cache, Filesystem $fileSystem)
	{
		$this->cache = $cache;
		$this->fs = $fileSystem;
	}

	public function execute(): Response
	{
		$app = config('app.name');
		$serverInfo = "PHP: " . \phpversion();
		$databaseInfo = $this->getDatabaseInfo();
		$redisInfo = $this->getRedisStatus();
		$storageInfo = $this->checkStorage();

		$response = new Response(
			$app,
			$serverInfo,
			$databaseInfo,
			$redisInfo,
			$storageInfo,
		);

		return $response;
	}

	private function getDatabaseInfo(): string
	{
		try {
			$result = DB::select('select version();');

			if (empty($result) || !isset($result)) {
				return '';
			}

			return $result[0]->version;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function getRedisStatus(): string
	{
		try {
			$redisInfo = Redis::info();
			$this->cache->set('healthcheck', true);
			$result = $this->cache->pull('healthcheck');

			return 'Redis ' . $redisInfo['redis_version'] . ', (' . $redisInfo['os'] . ') Cache: ' . ($result === true ? 'true' : 'false');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function checkStorage(): string
	{
		try {
			if ($this->fs->exists('healthcheck.txt')) {
				$this->fs->delete('healthcheck.txt');
			}
			$this->fs->put(
				'healthcheck.txt',
				'checked',
			);
			$data = $this->fs->get('healthcheck.txt');

			return 'Storage: ' . config('filesystems.default') . '. Accessability: ' . $data;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
