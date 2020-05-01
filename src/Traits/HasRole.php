<?php

namespace HttpOz\Roles\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

trait HasRole {

	/**
	 * Property for caching roles.
	 *
	 * @var \Illuminate\Database\Eloquent\Collection|null
	 */
	protected $roles;

	/**
	 * User belongs to many roles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() {
		return $this->belongsToMany( config( 'roles.models.role' ), 'role_user', 'user_id', 'role_id' )->withTimestamps();
	}

	/**
	 * Get all roles as collection.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getRoles() {
		if ( $this->cacheEnabled() ) {
			if ( is_null( $this->getCachedRoles() ) ) {
				Cache::remember( 'roles.user_' . $this->id, config( 'roles.cache.expiry' ), function () {
					return $this->roles()->get();
				} );
			}

			return $this->getCachedRoles();
		} else {
			return $this->roles()->get();
		}
	}

	/**
	 * Check if the user has a role or roles.
	 *
	 * @param int|string|array $role
	 * @param bool $all
	 *
	 * @return bool
	 */
	public function isRole( $role, $all = false ) {
		if ( $this->isPretendEnabled() ) {
			return $this->pretend( 'isRole' );
		}

		return $this->{$this->getMethodName( 'is', $all )}( $role );
	}

	/**
	 * Check if the user has at least one role.
	 *
	 * @param int|string|array $role
	 *
	 * @return bool
	 */
	public function isOne( $role ) {
		foreach ( $this->getArrayFrom( $role ) as $role ) {
			if ( $this->hasRole( $role ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the user has all roles.
	 *
	 * @param int|string|array $role
	 *
	 * @return bool
	 */
	public function isAll( $role ) {
		foreach ( $this->getArrayFrom( $role ) as $role ) {
			if ( ! $this->hasRole( $role ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if the user has role.
	 *
	 * @param int|string $role
	 *
	 * @return bool
	 */
	public function hasRole( $role ) {
		if ( $this->getRoles() ) {
			return $this->getRoles()->contains( function ( $value, $key ) use ( $role ) {
				return $role == $value->id || Str::is( $role, $value->slug );
			} );
		} else {
			return false;
		}
	}

	/**
	 * Attach role to a user.
	 *
	 * @param int|\HttpOz\Roles\Models\Role $role
	 *
	 * @return bool
	 */
	public function attachRole( $role ) {
		if ( ! $this->getRoles()->contains( $role ) ) {
			$this->clearCached();
			$this->roles()->attach( $role );
		}

		return true;
	}

	/**
	 * Detach role from a user.
	 *
	 * @param int|\HttpOz\Roles\Models\Role $role
	 *
	 * @return int
	 */
	public function detachRole( $role ) {
		$this->roles()->detach( $role );
		$this->clearCached();

		return true;
	}

	/**
	 * Detach all roles from a user.
	 *
	 * @return int
	 */
	public function detachAllRoles() {
		$this->clearCached();

		return $this->roles()->detach();
	}

	/**
	 * Sync roles for a user.
	 *
	 * @param array|\HttpOz\Roles\Models\Role[]|\Illuminate\Database\Eloquent\Collection $roles
	 *
	 * @return array
	 */
	public function syncRoles( $roles ) {
		$this->clearCached();

		return $this->roles()->sync( $roles );
	}

	/**
	 * Get role group of a user.
	 *
	 * @return int
	 */
	public function group() {
		return ( $role = $this->getRoles()->sortBy( 'group' )->first() ) ? $role->group : 'default';
	}

	/**
	 * Check if user belongs to a given group
	 *
	 * @param string $group
	 *
	 * @return boolean
	 */
	public function inGroup( $group ) {
		return ( $this->getRoles()->where( 'group', 'LIKE', $group )->first() ? true : false );
	}

	/**
	 * Check if pretend option is enabled.
	 *
	 * @return bool
	 */
	private function isPretendEnabled() {
		return (bool) config( 'roles.pretend.enabled' );
	}

	/**
	 * Allows to pretend or simulate package behavior.
	 *
	 * @param string $option
	 *
	 * @return bool
	 */
	private function pretend( $option ) {
		return (bool) config( 'roles.pretend.options.' . $option );
	}

	/**
	 * Get method name.
	 *
	 * @param string $methodName
	 * @param bool $all
	 *
	 * @return string
	 */
	private function getMethodName( $methodName, $all ) {
		return ( (bool) $all ) ? $methodName . 'All' : $methodName . 'One';
	}

	/**
	 * Get an array from argument.
	 *
	 * @param int|string|array $argument
	 *
	 * @return array
	 */
	private function getArrayFrom( $argument ) {
		return ( ! is_array( $argument ) ) ? preg_split( '/ ?[,|] ?/', $argument ) : $argument;
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

		return parent::__call( $method, $parameters );
	}

	/**
	 * Get flag on whether role caching is enabled
	 * @return boolean
	 */
	private function cacheEnabled() {
		return (bool) config( 'roles.cache.enabled' );
	}

	private function getCachedRoles() {
		return Cache::get( 'roles.user_' . $this->id );
	}

	private function clearCached() {
		return ( $this->cacheEnabled() ) ? Cache::forget( 'roles.user_' . $this->id ) : true;
	}

}
