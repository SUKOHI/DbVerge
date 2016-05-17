<?php namespace Sukohi\DbVerge;

use Illuminate\Support\ServiceProvider;

class DbVergeServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('command.db:verge', function ($app) {

			return $app['Sukohi\DbVerge\Commands\DbVerge'];

		});
		$this->commands('command.db:verge');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['db-verge'];
    }

}