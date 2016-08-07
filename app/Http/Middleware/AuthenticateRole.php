<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Validation\UnauthorizedException;

/**
 * Class AuthenticateRole
 *
 * @package    App\Http\Middleware
 * @subpackage App\Http\Middleware\AuthenticateRole
 */
class AuthenticateRole
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|array             $roles
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = !is_array($roles) ? [$roles] : $roles;

        if (!$request->getUser()->hasRoleByName($roles)) {
            throw new UnauthorizedException(sprintf("Access denied. Role required: %s", implode(', ', $roles)));
        }

        return $next($request);
    }
}
