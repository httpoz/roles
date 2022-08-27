<?php

namespace HttpOz\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use HttpOz\Roles\Exceptions\GroupDeniedException;
use Illuminate\Http\Request;


class VerifyGroup
{
    /**
     * Create a new filter instance.
     */
    public function __construct(protected Guard $auth)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $group
     * @return mixed
     * @throws GroupDeniedException
     */
    public function handle(Request $request, Closure $next, int $group): mixed
    {
        if ($this->auth->check() && $this->auth->user()->group() == $group) {
            return $next($request);
        }
        throw new GroupDeniedException($group);
    }
}
