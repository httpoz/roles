<?php

namespace HttpOz\Roles\Traits;

use HttpOz\Roles\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

trait HasRole
{

    /**
     * Property for caching roles.
     */
    protected ?Collection $roles;

    /**
     * User belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('roles.models.role'), 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * Get all roles as collection.
     *
     * @return Collection
     */
    public function getRoles(): Collection
    {
        if ($this->cacheEnabled()) {
            if (is_null($this->getCachedRoles())) {
                Cache::remember('roles.user_' . $this->id, config('roles.cache.expiry'), function () {
                    return $this->roles()->get();
                });
            }

            return $this->getCachedRoles();
        } else {
            return $this->roles()->get();
        }
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param array|int|string $role
     * @param bool $all
     *
     * @return bool
     */
    public function isRole(array|int|string $role, bool $all = false): bool
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('isRole');
        }

        return $this->{$this->getMethodName('is', $all)}($role);
    }

    /**
     * Check if the user has at least one role.
     *
     * @param array|int|string $role
     *
     * @return bool
     */
    public function isOne(array|int|string $role): bool
    {
        foreach ($this->getArrayFrom($role) as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all roles.
     *
     * @param array|int|string $role
     *
     * @return bool
     */
    public function isAll(array|int|string $role): bool
    {
        foreach ($this->getArrayFrom($role) as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has role.
     */
    public function hasRole(int|string $role): bool
    {
        if ($this->getRoles()) {
            return $this->getRoles()->contains(function ($value, $key) use ($role) {
                return $role == $value->id || Str::is($role, $value->slug);
            });
        } else {
            return false;
        }
    }

    /**
     * Attach role to a user.
     */
    public function attachRole(int|Role $role): bool
    {
        if (!$this->getRoles()->contains($role)) {
            $this->clearCached();
            $this->roles()->attach($role);
        }

        return true;
    }

    /**
     * Detach role from a user.
     */
    public function detachRole(int|Role $role): int
    {
        $this->roles()->detach($role);
        $this->clearCached();

        return true;
    }

    /**
     * Detach all roles from a user.
     */
    public function detachAllRoles(): int
    {
        $this->clearCached();

        return $this->roles()->detach();
    }

    /**
     * Sync roles for a user.
     *
     * @param array|Collection|Role[] $roles
     *
     * @return array
     */
    public function syncRoles(Collection|array $roles): array
    {
        $this->clearCached();

        return $this->roles()->sync($roles);
    }

    /**
     * Get role group of a user.
     */
    public function group(): string
    {
        return ($role = $this->getRoles()->sortBy('group')->first()) ? $role->group : 'default';
    }

    /**
     * Check if user belongs to a given group
     */
    public function inGroup(string $group): bool
    {
        return ($this->getRoles()->where('group', 'LIKE', $group)->first() ? true : false);
    }

    /**
     * Check if pretend option is enabled.
     */
    private function isPretendEnabled(): bool
    {
        return (bool)config('roles.pretend.enabled');
    }

    /**
     * Allows to pretend or simulate package behavior.
     */
    private function pretend(string $option): bool
    {
        return (bool)config('roles.pretend.options.' . $option);
    }

    /**
     * Get method name.
     */
    private function getMethodName(string $methodName, bool $all): string
    {
        return ((bool)$all) ? $methodName . 'All' : $methodName . 'One';
    }

    /**
     * Get an array from argument.
     */
    private function getArrayFrom(array|int|string $argument): array
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', $argument) : $argument;
    }

	/**
	 * Handle dynamic method calls.
	 *
	 * @param string $method
	 * @param array $parameters
	 *
	 * @return mixed
	 */
	public function __call( $method, $parameters ) {
		if ( Str::startsWith( $method, 'is' ) ) {
			return $this->isRole( Str::snake( substr( $method, 2 ), config( 'roles.separator' ) ) );
		}

        return parent::__call($method, $parameters);
    }

    /**
     * Get flag on whether role caching is enabled
     */
    private function cacheEnabled(): bool
    {
        return (bool)config('roles.cache.enabled');
    }

    private function getCachedRoles()
    {
        return Cache::get('roles.user_' . $this->id);
    }

    private function clearCached(): bool
    {
        return ($this->cacheEnabled()) ? Cache::forget('roles.user_' . $this->id) : true;
    }

}
