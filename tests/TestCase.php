<?php

namespace HttpOz\Roles\Tests;

use HttpOz\Roles\Tests\Stubs\User;
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

        $this->withFactories(__DIR__ . '/../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Database\ConsoleServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
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
                'role' => \HttpOz\Roles\Models\Role::class
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
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        include_once __DIR__ . '/../database/migrations/create_roles_table.php';
        include_once __DIR__ . '/../database/migrations/create_role_user_table.php';
        (new \CreateRolesTable())->up();
        (new \CreateRoleUserTable())->up();
    }
}
