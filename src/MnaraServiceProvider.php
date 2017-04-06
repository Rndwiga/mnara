<?php namespace Tyondo\Mnara;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Router;

class MnaraServiceProvider extends ServiceProvider {

    protected $providers = [
        'Collective\Html\HtmlServiceProvider',
        'PragmaRX\Google2FA\Vendor\Laravel\ServiceProvider',
        'Tyondo\MenuGenerator\TyondoMenuGeneratorServiceProvider',
    ];
    protected $aliases = [
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
        'Mnara' => 'Tyondo\Mnara\facades\MnaraFacade',
        'Google2FA' => 'PragmaRX\Google2FA\Vendor\Laravel\Facade',
    ];
    protected $middleware = [
        'role_mnara' => 'Tyondo\Mnara\Middleware\UserHasRole',
        'permission_mnara' => 'Tyondo\Mnara\Middleware\UserHasPermission',
    ];

    public function boot(Router $router, Dispatcher $event)
    {
        $this->registerMiddleware($router);
        $this->loadViewsFrom(__DIR__.'/Views', 'mnara');
        $this->registerViewComposers();
    }

    public function register()
    {
        //registering package service providers and aliases
        $this->registerServiceProviders();
        $this->registerAliases();
        $this->registerBladeDirectives();
        $this->registerPublishableResources();
        $this->registerConfigs();

        $this->app->singleton('mnara', function($app) {
            $auth = $app->make('Illuminate\Contracts\Auth\Guard');
             return new Mnara($auth);
        });

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
            $this->registerConsoleCommands();
        }
    }
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
    }
    protected function registerViewComposers()
    {
        $this->app['view']->composer('mnara::*',function($view){
            $view->theme = isset( Auth::user()->theme ) ? Auth::user()->theme : $this->app['config']->get('mnara.default_theme');
            $view->title = $this->app['config']->get('mnara.site_title');
        });
    }
    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/mnara.php', 'mnara');
        $this->mergeConfigFrom(__DIR__.'/Config/mnara_menu.php', 'mnara_menu');
        $this->mergeConfigFrom(__DIR__.'/Config/mnara_authenticator.php', 'mnara_authenticator');
    }
    private function registerPublishableResources()
    {
        $basePath = __DIR__;
        $publishable = [
            'mnara_assets' => [
                "$basePath/Assets/" => public_path('vendor/tyondo/mnara'),
            ],
            'migrations' => [
                "$basePath/Database/migrations/" => database_path('migrations'),
            ],
            'seeds' => [
                "$basePath/Database/seeds/" => database_path('seeds'),
            ],
            'views' => [
                "$basePath/Views/" => base_path('resources/views/vendor/mnara'),
            ],
            'config' => [
                "$basePath/Config/mnara.php" => config_path('mnara.php'),
                "$basePath/Config/mnara_menu.php" => config_path('mnara_menu.php'),
                "$basePath/Config/mnara_authenticator.php" => config_path('mnara_authenticator.php'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    /**
     * @return void
     */
    private function registerServiceProviders()
    {
        foreach ($this->providers as $provider)
        {
            $this->app->register($provider);
        }
    }
    /**
     * @return void
     */
    private function registerAliases()
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->aliases as $key => $alias)
        {
            $loader->alias($key, $alias);
        }
    }

    private function registerMiddleware($router)
    {
        if (app()->version() >= 5.4) {
            foreach ($this->middleware as $key => $alias)
            {
                $router->aliasMiddleware($key, $alias);
            }
        } else {
            foreach ($this->middleware as $key => $alias)
            {
                $router->middleware($key, $alias);
            }
        }

    }
    protected function registerBladeDirectives()
    {
        Blade::directive('can', function ($expression) {
            return "<?php if (\\Mnara::can({$expression})): ?>";
        });

        Blade::directive('endcan', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('canatleast', function ($expression) {
            return "<?php if (\\Mnara::canAtLeast({$expression})): ?>";
        });

        Blade::directive('endcanatleast', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('role', function ($expression) {
            return "<?php if (\\Mnara::isRole({$expression})): ?>";
        });

        Blade::directive('endrole', function ($expression) {
            return '<?php endif; ?>';
        });
    }


}
