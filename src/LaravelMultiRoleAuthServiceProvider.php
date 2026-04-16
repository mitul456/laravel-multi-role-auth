<?php

namespace Mitul456\LaravelMultiRoleAuth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Mitul456\LaravelMultiRoleAuth\Commands\CreateRoleCommand;
use Mitul456\LaravelMultiRoleAuth\Commands\AssignRoleCommand;
use Mitul456\LaravelMultiRoleAuth\Commands\SyncRoleCommand;
use Mitul456\LaravelMultiRoleAuth\Commands\InstallCommand;
use Mitul456\LaravelMultiRoleAuth\Middleware\RoleMiddleware;
use Mitul456\LaravelMultiRoleAuth\Middleware\RoleOrMiddleware;
use Mitul456\LaravelMultiRoleAuth\Http\Middleware\RoleApiMiddleware;

class LaravelMultiRoleAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/multirole.php',
            'multirole'
        );

        $this->app->singleton('multirole', function ($app) {
            return new MultiRoleAuth();
        });
    }

    public function boot(Router $router): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'multirole');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'multirole');

        $this->publishes([
            __DIR__ . '/../config/multirole.php' => config_path('multirole.php'),
        ], 'multirole-config');

        $this->publishes([
            __DIR__ . '/Database/Migrations/' => database_path('migrations'),
        ], 'multirole-migrations');

        $this->publishes([
            __DIR__ . '/Database/Seeders/' => database_path('seeders'),
        ], 'multirole-seeds');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/multirole'),
        ], 'multirole-views');

        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('role.or', RoleOrMiddleware::class);
        $router->aliasMiddleware('role.api', RoleApiMiddleware::class);

        // ✅ Register Event Listener (CORRECT WAY)
        $this->app['events']->listen(
            \Mitul456\LaravelMultiRoleAuth\Events\UserRegistered::class,
            \Mitul456\LaravelMultiRoleAuth\Listeners\AssignDefaultRole::class
        );

        $this->registerBladeDirectives();
        $this->registerCommands();
    }
    protected function registerBladeDirectives(): void
    {
        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('hasrole', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endhasrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canrole', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->can({$expression})): ?>";
        });

        Blade::directive('endcanrole', function () {
            return "<?php endif; ?>";
        });
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRoleCommand::class,
                AssignRoleCommand::class,
                SyncRoleCommand::class,
                InstallCommand::class,
            ]);
        }
    }
}