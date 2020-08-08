<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function withJwt($user)
    {
        $token = \JWTAuth::fromUser($user);

        return $this->withHeaders([ 'Authorization' => 'Bearer ' . $token]);
    }
}
