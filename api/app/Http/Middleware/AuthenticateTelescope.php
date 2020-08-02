<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticateTelescope
{
    public function handle($request, Closure $next)
    {
        if (app()->environment('local')
            || app()->environment('staging')
            || $request->getUser() === env('TELESCOPE_USER')
                && $request->getPassword() === env('TELESCOPE_PASSWORD')
        ) {
            return $next($request);
        }

        throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
    }
}
