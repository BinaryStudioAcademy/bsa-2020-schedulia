<?php

declare(strict_types=1);

namespace App\Helpers\Configs;

class RedisConfig
{
    public const REDIS_SCHEME_REGEXP = '/^redis:\/\/(.+):(.+)@(.+):(\d+)$/';

    public string $url;
    public string $host;
    public string $port;
    public ?string $password;
    public ?string $database;

    public function __construct(
        string $url,
        string $host,
        string $port,
        ?string $password,
        ?string $database
    ) {
        $this->url = $url;
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->database = $database;
    }

    public static function parse(
        string $url,
        string $host,
        string $port,
        ?string $password,
        ?string $database
    ): RedisConfig {
        $parsedUri = [];

        if (preg_match(self::REDIS_SCHEME_REGEXP, $url, $parsedUri)) {
            return new RedisConfig(
                $parsedUri[3],
                $parsedUri[3],
                $parsedUri[4],
                $parsedUri[2],
                $database
            );
        } else {
            return new RedisConfig(
                $url,
                $host,
                $port,
                $password,
                $database
            );
        }
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'host' => $this->host,
            'port' => $this->port,
            'password' => $this->password,
            'database' => $this->database
        ];
    }
}
