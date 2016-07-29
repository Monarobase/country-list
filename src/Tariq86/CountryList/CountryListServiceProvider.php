<?php
 /*
 * This file is part of Tariq86-CountryList
 *
 * (c) 2016 Tariq86
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Tariq86
 * @package     CountryList
 * @copyright   (c) 2016 Tariq86
 */

namespace Tariq86\CountryList;

use Illuminate\Support\ServiceProvider;

/**
 * CountryListServiceProvider
 *
 * @author Tariq86
 */
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
		return ['countrylist'];
	}

}
