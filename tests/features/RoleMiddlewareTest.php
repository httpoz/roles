<?php

namespace HttpOz\Roles\Tests;

use App\User;
use HttpOz\Roles\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleMiddlewareTest extends TestCase {

  use DatabaseMigrations;

  /**
   * A basic test example.
   *
   * @return void
   */
  public function testForbiddenRoleRoute() {
    $createdUser = factory(User::class)->create();
    $createdRole = factory(Role::class)->create([
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

    $this->get('/admin/users')
         ->assertStatus(200)
         ->assertSee('I am an admin.');
  }
}