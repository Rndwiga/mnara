<?php namespace Tyondo\Mnara;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
//use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Facades\Config;
//use Illuminate\Support\Facades\Route;

/**
 * A Laravel 5.3 user package
 *
 * @author: Rndwiga
 */
class MnaraServiceProvider extends ServiceProvider {
    /**
     * Indicates of loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * This will be used to register config & view in 
     * your package namespace.
     *
     */
    protected $packageName = 'mnara';
    /**
     * @var array
     */
    protected $providers = [
        'Collective\Html\HtmlServiceProvider', // For Mnara Forms to function
    ];
    /**
     * @var array
     */
    protected $aliases = [
        'Form' => 'Collective\Html\FormFacade', // required for Mnara Forms
        'Html' => 'Collective\Html\HtmlFacade', // required for Mnara Forms
        'Mnara' => 'Tyondo\Mnara\facades\MnaraFacade' // not required, but available
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191);
		//loading routes
        $this->loadRoutesFrom(__DIR__.'/Routes/webRoutes.php');
        // Merge config files
        $this->mergeConfigFrom(__DIR__.'/Config/mnara.php', $this->packageName);
        $this->mergeConfigFrom(__DIR__.'/Config/mnara-menu.php', $this->packageName.'-menu');
        // Register your assets
        $this->publishes([
            __DIR__.'/Assets' => public_path('vendor/'.$this->packageName),
        ], 'public');
		
		// Register Views
        $this->loadViewsFrom(__DIR__.'/views', $this->packageName);
		
        // Publish your config files
        $this->publishes([
            __DIR__.'/Config/mnara.php' => config_path($this->packageName.'.php')
        ], 'config');
		
        $this->publishes([
            __DIR__.'/Config/mnara-menu.php' => config_path($this->packageName.'-menu.php')
        ], 'config-menu');
		// Publish views
        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor/'.$this->packageName)
        ], 'views');
    //composer for determining which theme to use
        $this->app['view']->composer('*',function($view){
            $view->theme = isset( Auth::user()->theme ) ? Auth::user()->theme : $this->app['config']->get('mnara.default_theme');
            $view->title = $this->app['config']->get('mnara.site_title');
        });
		
        // Register your migration's publisher
        $this->publishes([
            __DIR__.'/Database/migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //registering package service providers and aliases
        $this->registerServiceProviders();
        $this->registerMiddleware();
        $this->registerAliases();
        $this->registerBladeDirectives();

        // Register it
        $this->app->singleton('mnara', function($app) {
            $auth = $app->make('Illuminate\Contracts\Auth\Guard');
             return new Mnara($auth);
        });
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
    /**
     * @return void
     */
    private function registerMiddleware()
    {
        $this->app['router']->middleware('roleMnara', 'Tyondo\Mnara\Middleware\UserHasRole');
        $this->app['router']->middleware('permissionMnara', 'Tyondo\Mnara\Middleware\UserHasPermission');
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
