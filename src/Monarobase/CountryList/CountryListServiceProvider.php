<?php namespace Monarobase\CountryList;

use Illuminate\Support\ServiceProvider;

class CountryListServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['countrylist'] = $this->app->share(function($app)
		{
			return new CountryList;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('countrylist');
	}

}