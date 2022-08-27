<?php

namespace HttpOz\Roles\Tests;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\RolesServiceProvider;
use HttpOz\Roles\Tests\Stubs\User;
use Illuminate\Foundation\Application;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app): array
    {
        return [
            RolesServiceProvider::class,
            ConsoleServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('roles', [
            'connection' => null,
            'separator' => '.',
            'cache' => [
                'enabled' => false,
                'expiry' => 20160,
            ],
            'models' => [
                'role' => Role::class
            ],
            'pretend' => [
                'enabled' => false,
                'options' => [
                    'isRole' => true
                ],
            ],
        ]);
    }

    /**
     * Set up the database.
     */
    protected function setUpDatabase(Application $app)
    {
        include_once __DIR__ . '/../database/migrations/2016_09_02_000000_create_roles_table.php';
        include_once __DIR__ . '/../database/migrations/2016_09_02_000000_create_role_user_table.php';
        (new \CreateRolesTable())->up();
        (new \CreateRoleUserTable())->up();
    }
}
