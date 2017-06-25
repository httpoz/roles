<?php

namespace HttpOz\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use HttpOz\Roles\Exceptions\RoleDeniedException;


class VerifyRole
{

    const DELIMITER = '|';

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $role
     * @return mixed
     * @throws \HttpOz\Roles\Exceptions\RoleDeniedException
     */
    public function handle($request, Closure $next, $role)
    {
        if (strpos(self::DELIMITER,$role)){
            $roles=explode(self::DELIMITER,$role);
            if ($this->auth->check() && $this->auth->user()->isOne($roles)) {
                return $next($request);
            }
        }else if ($this->auth->check() && $this->auth->user()->isRole($role)) {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
