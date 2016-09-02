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
            __DIR__ . '/../../config/roles.php' => config_path('roles.php')
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../migrations/');

        $this->registerBladeExtensions();
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/roles.php', 'roles');
    }

    public function registerBladeExtensions()
    {

        Blade::directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->isRole{$expression}): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('group', function ($expression) {
            $level = trim($expression, '()');
            return "<?php if (Auth::check() && Auth::user()->group()): ?>";
        });
        Blade::directive('endgroup', function () {
            return "<?php endif; ?>";
        });
    }
}