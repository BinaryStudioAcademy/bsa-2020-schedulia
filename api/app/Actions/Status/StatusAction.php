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

    public function execute(?string $serviceName = 'all'): StatusResponse
    {
        switch($serviceName) {
            case 'app':
                return new StatusResponse(
                    $this->createApplicationInfo()
                );
            case 'server':
                return new StatusResponse(
                    $this->createServerInfo()
                );
            case 'database':
                return new StatusResponse(
                    $this->createDatabaseInfo()
                );
            case 'redis':
                return new StatusResponse(
                    $this->createRedisInfo()
                );
            case 'storage':
                return new StatusResponse(
                    $this->createStorageInfo()
                );
            case 'all':
            default:
                return new StatusResponse(
                    $this->createApplicationInfo(),
                    $this->createServerInfo(),
                    $this->createDatabaseInfo(),
                    $this->createRedisInfo(),
                    $this->createStorageInfo(),
                );
        }
    }

    private function createApplicationInfo(): StatusParameter
    {
        return new StatusParameter(
            'app',
            config('app.name') . ' | ' . config('app.env')
        );
    }

    private function createServerInfo(): StatusParameter
    {
        return new StatusParameter(
            'server',
            'PHP: ' . \phpversion() . ' | ' . 'IP: ' . $_SERVER['REMOTE_ADDR']
        );
    }

    private function createDatabaseInfo(): StatusParameter
    {
        return new StatusParameter(
            'database',
            $this->getDatabaseInfo()
        );
    }

    private function createRedisInfo(): StatusParameter
    {
        return new StatusParameter(
            'redis',
            $this->getRedisInfo()
        );
    }

    private function createStorageInfo(): StatusParameter
    {
        return new StatusParameter(
            'storage',
            $this->getStorageInfo()
        );
    }

    private function getDatabaseInfo(): string
    {
        $result = DB::select('select version();');

        if (empty($result) || !isset($result)) {
            return '';
        }

        return $result[0]->version;
    }

    private function getRedisInfo(): string
    {
        $redisInfo = Redis::info();
        $this->cache->set('healthcheck', true);
        $result = $this->cache->pull('healthcheck');

        return 'Redis ' . $redisInfo['redis_version'] . ', (' . $redisInfo['os'] . ') Cache: ' . ($result === true ? 'true' : 'false');
    }

    private function getStorageInfo(): string
    {
        if ($this->fs->exists('healthcheck.txt')) {
            $this->fs->delete('healthcheck.txt');
        }
        $this->fs->put(
            'healthcheck.txt',
            'checked',
        );
        $data = $this->fs->get('healthcheck.txt');

        return 'Storage: ' . config('filesystems.default') . '. Accessability: ' . $data;
    }
}
