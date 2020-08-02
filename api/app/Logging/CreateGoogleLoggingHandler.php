<?php

declare(strict_types=1);

namespace App\Logging;

use Monolog\Handler\PsrHandler;
use Google\Cloud\Logging\LoggingClient;

class CreateGoogleLoggingHandler
{
    public function __invoke(array $config)
    {
        $keyFile = $config['key_file'];

        if (!is_array($keyFile)) {
            $keyFile = [];
        }

        $logging = new LoggingClient([
            'projectId' => $config['project_id'],
            'keyFile' => array_merge($keyFile, [ 'project_id' => $config['project_id'] ]),
        ]);
        $logger = $logging->psrLogger($config['logger_name']);

        return $logger;
    }
}
