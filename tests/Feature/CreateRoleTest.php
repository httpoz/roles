<?php

namespace HttpOz\Roles\Tests\Feature;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\TestCase;

class CreateRoleTest extends TestCase
{
  /**
   * A basic test example.
   *
   * @return void
   */
    public function testCanCreateRole()
    {
        $adminRole = Role::factory()->create([
        'name'        => 'Admin',
        'slug'        => 'admin',
        'description' => 'Custodians of the system.',
        'group'       => 'default'
        ]);

        $role = Role::whereSlug('admin')->first();

        $this->assertEquals('admin', $role->slug);
    }
}
