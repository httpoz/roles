<?php

namespace HttpOz\Roles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class RolesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/roles.php' => config_path('roles.php')
        ], 'config');
        
        $stub      = __DIR__ . '/../database/migrations/';
        $target    = database_path('migrations').'/';
        
        $this->publishes([
            $stub.'create_roles_table.php'     => $target . '2016_09_04_000000_create_roles_table.php',
            $stub.'create_role_user_table.php' => $target . '2016_09_04_100000_create_role_user_table.php'
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor'),
        ], 'views');

        $this->registerBladeExtensions();
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/roles.php', 'roles');
    }

    public function registerBladeExtensions()
    {

        Blade::directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->isRole($expression)): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('group', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->group() == $expression): ?>";
        });
        Blade::directive('endgroup', function () {
            return "<?php endif; ?>";
        });
    }
}
