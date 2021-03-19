<?php

namespace HttpOz\Roles\Tests\Feature;

use \HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\Stubs\User;
use HttpOz\Roles\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RoleMiddlewareTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testForbiddenRoleRoute()
    {
        $createdUser = User::factory()->create();
        $createdRole = Role::factory()->create([
          'name' => 'Admin',
          'slug' => 'admin',
        ]);

        $foundRole = Role::findBySlug('admin');
        $foundUser = User::first();

        $foundUser->detachAllRoles();
        $foundUser->attachRole($foundRole);

        $this->actingAs($createdUser);


        $this->assertEquals($createdRole->id, $foundRole->id);
        $this->assertEquals($createdUser->name, $foundUser->name);
    }
}
