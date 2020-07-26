<?php

declare(strict_types=1);

namespace App\Actions\Status;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Filesystem\Filesystem;

class StatusAction
{
	private Cache $cache;
	private Filesystem $fs;

	public function __construct(Cache $cache, Filesystem $fileSystem)
	{
		$this->cache = $cache;
		$this->fs = $fileSystem;
	}

	public function execute(?string $serviceName = 'all'): Response
	{
		switch($serviceName) {
			case 'app':
				return new Response(
					$this->createApplicationInfo()
				);
			case 'server':
				return new Response(
					$this->createServerInfo()
				);
			case 'database':
				return new Response(
					$this->createDatabaseInfo()
				);
			case 'redis':
				return new Response(
					$this->createRedisInfo()
				);
			case 'storage':
				return new Response(
					$this->createStorageInfo()
				);
			case 'all':
			default:
				return new Response(
					$this->createApplicationInfo(),
					$this->createServerInfo(),
					$this->createDatabaseInfo(),
					$this->createRedisInfo(),
					$this->createStorageInfo(),
				);
		}

		return $response;
	}

	private function createApplicationInfo(): Parameter
	{
		return new Parameter(
			'app',
			config('app.name') . ' | ' . config('app.env')
		);
	}

	private function createServerInfo(): Parameter
	{
		return new Parameter(
			'server',
			'PHP: ' . \phpversion() . ' | ' . 'IP: ' . $_SERVER['REMOTE_ADDR']
		);
	}

	private function createDatabaseInfo(): Parameter
	{
		return new Parameter(
			'database',
			$this->getDatabaseInfo()
		);
	}

	private function createRedisInfo(): Parameter
	{
		return new Parameter(
			'redis',
			$this->getRedisInfo()
		);
	}

	private function createStorageInfo(): Parameter
	{
		return new Parameter(
			'storage',
			$this->getStorageInfo()
		);
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

	private function getRedisInfo(): string
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

	private function getStorageInfo(): string
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
