<?php namespace Sukohi\DbVerge;

use Illuminate\Support\ServiceProvider;
use Sukohi\DbVerge\Commands\DbVerge;

class DbVergeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('sukohi/db-verge');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['db-verge'] = $this->app->share(function($app)
		{
			return new DbVerge();
		});

		$this->commands('db-verge');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
