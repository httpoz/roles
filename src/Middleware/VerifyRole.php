<?php

namespace HttpOz\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use HttpOz\Roles\Exceptions\RoleDeniedException;
use Illuminate\Http\Request;


class VerifyRole
{
    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(protected Guard $auth)
    {
    }

    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @param int|string $role
     * @return mixed
     * @throws RoleDeniedException
     */
    public function handle(Request $request, Closure $next, int|string $role): mixed
    {
        if ($this->auth->check() && $this->auth->user()->isRole($role)) {
            return $next($request);
        }
        throw new RoleDeniedException($role);
    }
}
