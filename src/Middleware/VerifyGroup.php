<?php

namespace HttpOz\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use HttpOz\Roles\Exceptions\GroupDeniedException;


class VerifyGroup
{
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
     * @param int $group
     * @return mixed
     * @throws \HttpOz\Roles\Exceptions\GroupDeniedException
     */
    public function handle($request, Closure $next, $group)
    {
        if ($this->auth->check() && $this->auth->user()->group() == $group) {
            return $next($request);
        }
        throw new GroupDeniedException($group);
    }
}
