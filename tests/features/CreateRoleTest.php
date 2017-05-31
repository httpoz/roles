<?php

namespace HttpOz\Roles\Tests;

use HttpOz\Roles\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateRoleTest extends TestCase
{
  use DatabaseMigrations;
  /**
   * A basic test example.
   *
   * @return void
   */
  public function testCanCreateRole()
  {
    $adminRole = factory(Role::class)->create([
      'name'        => 'Admin',
      'slug'        => 'admin',
      'description' => 'Custodians of the system.',
      'group'       => 'default'
    ]);

    $role = Role::whereSlug('admin')->first();

    $this->assertEquals('admin', $role->slug);

  }
}