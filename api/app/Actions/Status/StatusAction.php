<?php

declare(strict_types=1);

namespace App\Actions\Status;

use Illuminate\Cache\CacheManager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Redis\RedisManager;

class StatusAction
{
    private DatabaseManager $databaseManager;
    private FilesystemManager $filesystemManager;
    private RedisManager $redisManager;
    private CacheManager $cacheManager;

    public function __construct(
        DatabaseManager $databaseManager,
        FilesystemManager $filesystemManager,
        RedisManager $redisManager,
        CacheManager $cacheManager
    ) {
        $this->databaseManager = $databaseManager;
        $this->filesystemManager = $filesystemManager;
        $this->redisManager = $redisManager;
        $this->cacheManager = $cacheManager;
    }

    public function execute(?string $serviceName = 'all'): StatusResponse
    {
        switch ($serviceName) {
            case 'app':
                return new StatusResponse(
                    $this->createApplicationInfo()
                );
            case 'server':
                return new StatusResponse(
                    $this->createServerInfo()
                );
            case 'redis':
                return new StatusResponse(
                    $this->createRedisInfo()
                );
            case 'cache':
                return new StatusResponse(
                    $this->createCacheInfo()
                );
            case 'database':
                return new StatusResponse(
                    $this->createDatabaseInfo()
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
                    $this->createRedisInfo(),
                    $this->createCacheInfo(),
                    $this->createDatabaseInfo(),
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

    private function createRedisInfo(): StatusParameter
    {
        return new StatusParameter(
            'redis',
            $this->getRedisInfo()
        );
    }

    private function createCacheInfo(): StatusParameter
    {
        return new StatusParameter(
            'cache',
            $this->getCacheInfo()
        );
    }

    private function createDatabaseInfo(): StatusParameter
    {
        return new StatusParameter(
            'database',
            $this->getDatabaseInfo()
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
        $result = $this->databaseManager->connection()->select('select version();');

        if (empty($result) || !isset($result)) {
            return '';
        }

        return $result[0]->version;
    }

    private function getRedisInfo(): string
    {
        $redisInfo = $this->redisManager->command('info');

        return 'Redis ' . $redisInfo['redis_version'] . ', (' . $redisInfo['os'] . ')';
    }

    private function getCacheInfo(): string
    {
        $cache = $this->cacheManager->driver();
        $cache->set('healthcheck', true);
        $result = $cache->pull('healthcheck');

        return 'Driver: ' . $this->cacheManager->getDefaultDriver() . '. Cache: ' . ($result === true ? 'true' : 'false');
    }

    private function getStorageInfo(): string
    {
        $fs = $this->filesystemManager->drive();

        if ($fs->exists('healthcheck.txt')) {
            $fs->delete('healthcheck.txt');
        }

        $fs->put(
            'healthcheck.txt',
            'checked',
        );
        $data = $fs->get('healthcheck.txt');

        return 'Driver: ' . $this->filesystemManager->getDefaultDriver() . '. Accessability: ' . $data;
    }
}
