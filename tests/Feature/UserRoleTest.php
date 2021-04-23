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
        $admin->detachAllRoles();
        $admin->attachRole($adminRole);

        $this->assertEquals($role->slug, $adminRole->slug);
    }

    public function testUserHasOneRoleOnAttachDuplicate()
    {
        $admin = User::factory()->create();
        $role  = Role::factory()->create();

        $admin->attachRole($role);
        $admin->attachRole($role);

        $this->assertCount(1, $admin->roles);
    }
}
