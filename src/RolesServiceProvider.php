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
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

        // publish config file
        $this->publishes([__DIR__ . '/../config/roles.php' => config_path('roles.php')], 'config');

        // publish views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'roles');

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
