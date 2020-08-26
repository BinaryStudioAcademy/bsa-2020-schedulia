<?php

namespace App\Services\SocialAccount;

use Illuminate\Config\Repository;
use App\Contracts\CalendarService;
use App\Contracts\SocialAccountService;

class Google implements SocialAccountService, CalendarService
{
    protected $client;
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->client = $this->setupClient();
    }

    public function __call($method, $args)
    {
        if ( !method_exists($this->client, $method) ) {
            throw new \Exception("Call to undefined method '{$method}'");
        }

        return call_user_func_array([$this->client, $method], $args);
    }

    public function service($service)
    {
        $classname = 'Google_Service_' . $service;

        return new $classname($this->client);
    }

    public function auth(): string
    {
        return $this->createAuthUrl();
    }

    public function connect($token)
    {
        $this->client->setAccessToken($token);

        return $this;
    }

    public function revokeToken($token = null)
    {
        $token = $token ?? $this->client->getAccesToken();

        return $this->client->revokeToken($token);
    }

    public function createEvent(): void
    {
        // TODO: Implement createEvent() method.
    }

    public function deleteEvent(): void
    {
        // TODO: Implement deleteEvent() method.
    }

    private function setupClient()
    {
        $options = $this->config->get('services.google');

        $client = new \Google_Client();
        $client->setClientId($options['client_id']);
        $client->setClientSecret($options['client_secret']);
        $client->setRedirectUri($options['redirect_uri']);
        $client->setScopes($options['scopes']);
        $client->setApprovalPrompt($options['approval_prompt']);
        $client->setAccessType($options['access_type']);

        return $client;
    }

}