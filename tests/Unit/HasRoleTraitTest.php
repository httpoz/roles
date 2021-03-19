<?php

namespace HttpOz\Roles\Tests\Unit;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\Stubs\User;
use HttpOz\Roles\Tests\TestCase;

class HasRoleTraitTest extends TestCase
{
    public function testCanAttachRole()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->attachRole($adminRole);

        $this->assertEquals(1, $user->roles()->count());
    }

    public function testCanDetachRole()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->attachRole($adminRole);
        $user->attachRole($managerRole);

        $user->detachRole($adminRole);

        $this->assertEquals(1, $user->roles()->count());
        $this->assertEquals('manager', $user->roles()->first()->slug);
    }

    public function testCanDetachAllRoles()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->attachRole($adminRole);
        $user->attachRole($managerRole);

        $this->assertEquals(2, $user->roles()->count());

        $user->detachAllRoles();

        $this->assertEquals(0, $user->roles()->count());
    }

    public function testHasRole()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->attachRole($adminRole);

        $this->assertFalse($user->hasRole('manager'));

        config(['roles.cache.enabled' => true]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('manager'));
    }

    public function testIsRole()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);
        $user->attachRole($adminRole);

        $this->assertTrue($user->isRole($adminRole->slug));
        $this->assertFalse($user->isRole($managerRole->slug));

        config(['roles.pretend.enabled' => true]);


        $this->assertTrue($user->isRole($managerRole->slug));
    }

    public function testIsAll()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);
        $user->attachRole($adminRole);
        $user->attachRole($managerRole);

        $this->assertTrue($user->isAll([$adminRole->id, $managerRole->id]));
    }

    public function testSyncRoles()
    {
        $user = User::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->syncRoles([$managerRole->id, $adminRole->id]);

        $this->assertTrue($user->isAll([$adminRole->id, $managerRole->id]));

        config(['roles.pretend.enabled' => true]);

        $this->assertTrue($user->isAll([$adminRole->id, $managerRole->id]));
    }

    public function testGroup()
    {
        $user = USer::factory()->create([
            'name' => 'The Oz'
        ]);
        $adminRole = Role::factory()->create();
        $managerRole = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);
        $user->attachRole($adminRole);

        $this->assertEquals('system.admin', $user->group());
        $this->assertTrue($user->inGroup('system.admin'));
        $this->assertFalse($user->inGroup('default'));

    }
}