<?php

namespace HttpOz\Roles\Tests\Feature;

use HttpOz\Roles\Tests\Stubs\User;
use \HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\TestCase;

class UserRoleTest extends TestCase
{

    public function testUserHasRoleOnAttach()
    {
        $admin = User::factory()->create();
        $role  = Role::factory()->create();

        $adminRole = Role::findBySlug('admin');
        $user = User::find(1);
        $admin->detachAllRoles();
        $admin->attachRole($adminRole);

        $this->assertEquals($role->slug, $adminRole->slug);
    }
}
