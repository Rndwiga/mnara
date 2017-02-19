<?php namespace Tyondo\Mnara;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

use Config;

/**
 * A Laravel package package template.
 *
 * @author: Rndwiga
 */
class MnaraServiceProvider extends ServiceProvider {

    /**
     * This will be used to register config & view in 
     * your package namespace.
     *
     * --> Replace with your package name <--
     */
    protected $packageName = 'mnara';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       // include __DIR__.'webRoutes.php';
        //loading routes
        $this->loadRoutesFrom(__DIR__.'/webRoutes.php');
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
        // Merge config files
		$this->mergeConfigFrom(__DIR__.'/config/mnara.php', $this->packageName);
        $this->mergeConfigFrom(__DIR__.'/config/mnara-menu.php', $this->packageName.'-menu');
        /*
         * When transferred to a package
         * if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
        */

		        // View Composer
        $this->app['view']->composer('*',function($view){
           $view->theme = isset( Auth::user()->theme ) ? Auth::user()->theme : $this->app['config']->get('mnara.default_theme');
           $view->title = $this->app['config']->get('mnara.site_title');
        });

        // Register it
        $this->app->bind('mnara', function() {
             return new Mnara;
        });
    }

}
