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
        'Spatie\Activitylog\ActivitylogServiceProvider',
    ];
    protected $aliases = [
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
        'Mnara' => 'Tyondo\Mnara\facades\MnaraFacade',
        'Google2FA' => 'PragmaRX\Google2FA\Vendor\Laravel\Facade',
    ];
    protected $middleware = [
        'role_mnara' => 'Tyondo\Mnara\Http\Middleware\UserHasRole',
        'permission_mnara' => 'Tyondo\Mnara\Http\Middleware\UserHasPermission',
    ];
    protected  $basePath = __DIR__;
    protected $publishableDir = __DIR__.'/../Publishable';

    public function boot(Router $router, Dispatcher $event)
    {
        $this->registerMiddleware($router);
        $this->loadViewsFrom($this->publishableDir .'/Resources/views', 'mnara');
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
            $view->title = $this->app['config']->get('mnara.site_title');
        });
    }
    protected function registerConfigs()
    {
        $this->mergeConfigFrom($this->publishableDir . '/Config/mnara.php', 'mnara');
        $this->mergeConfigFrom($this->publishableDir . '/Config/mnara_menu.php', 'mnara_menu');
    }
    private function registerPublishableResources()
    {
        $publishable = [
            'mnara_assets' => [
                "$this->publishableDir/Public/" => public_path('vendor/tyondo/mnara'),
            ],
            'migrations' => [
                "$this->basePath/Database/migrations/" => database_path('migrations'),
            ],
            'seeds' => [
                "$this->basePath/Database/seeds/" => database_path('seeds'),
            ],
            'views' => [
                "$this->publishableDir/Resources/views/" => base_path('resources/views/vendor/mnara'),
            ],
            'config' => [
                "$this->publishableDir/Config/mnara.php" => config_path('mnara.php'),
                "$this->publishableDir/Config/mnara_menu.php" => config_path('mnara_menu.php'),
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
