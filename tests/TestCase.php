<?php
namespace HttpOz\Roles\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->artisan('migrate', ['--database' => 'testbench']);


         $this->loadMigrationsFrom([
             '--database' => 'testbench',
             '--realpath' => realpath(__DIR__.'../database/migrations'),
         ]);

        $this->withFactories(__DIR__.'/../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            \HttpOz\Roles\RolesServiceProvider::class,
            \Orchestra\Database\ConsoleServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
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
}
