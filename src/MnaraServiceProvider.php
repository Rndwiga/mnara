<?php namespace Tyondo\Mnara;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;

/**
 * A Laravel package package template.
 *
 * @author: Rndwiga
 */
class MnaraServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Tyondo\Mnara\Controllers';

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
        'Caffeinated\Shinobi\ShinobiServiceProvider', // For RBAC
        'Collective\Html\HtmlServiceProvider', // For Mnara Forms to function
    ];
    /**
     * @var array
     */
    protected $aliases = [
        'Form' => 'Collective\Html\FormFacade', // required for Mnara Forms
        'Html' => 'Collective\Html\HtmlFacade', // required for Mnara Forms
        'Shinobi' => 'Caffeinated\Shinobi\Facades\Shinobi', // For RBAC functions
        'Mnara' => 'Tyondo\Mnara\MnaraFacade' // not required, but available
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // include __DIR__.'/webRoutes.php';
        //loading routes
        $this->loadRoutesFrom(__DIR__.'/webRoutes.php');
        // Merge config files
        $this->mergeConfigFrom(__DIR__.'/config/mnara.php', $this->packageName);
        $this->mergeConfigFrom(__DIR__.'/config/mnara-menu.php', $this->packageName.'-menu');
        // Register your assets
        $this->publishes([
            __DIR__.'/../assets' => public_path('vendor/'.$this->packageName),
        ], 'public');
		
		// Register Views
        $this->loadViewsFrom(__DIR__.'/views', $this->packageName);
		
        // Publish your config files
        $this->publishes([
            __DIR__.'/config/mnara.php' => config_path($this->packageName.'.php')
        ], 'config');
		
        $this->publishes([
            __DIR__.'/config/mnara-menu.php' => config_path($this->packageName.'-menu.php')
        ], 'config-menu');
		// Publish views
        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor/'.$this->packageName)
        ], 'views');

        $this->app['view']->composer('*',function($view){
            $view->theme = isset( Auth::user()->theme ) ? Auth::user()->theme : $this->app['config']->get('mnara.default_theme');
            $view->title = $this->app['config']->get('mnara.site_title');
        });
		
						// Register your migration's publisher
						$this->publishes([
							__DIR__.'/../database/migrations/' => base_path('/database/migrations')
						], 'migrations');
						
						// Publish your seed's publisher
						$this->publishes([
							__DIR__.'/../database/seeds/' => base_path('/database/seeds')
						], 'seeds');
				
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
        $this->registerAliases();
        /*
         * if (! $this->app->routesAreCached()) {
            require __DIR__.'/webRoutes.php';
        }
         * */

		        // View Composer
        // Register it
        $this->app->singleton('mnara', function() {
             return new Mnara;
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

}
