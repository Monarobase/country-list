<?php
declare(strict_types=1);

namespace Clarity\CurrencyList;

/**
 * This file is part of Clarity-CurrencyList
 * Reference : Monarobase-CountryList by Jonathan Thuau <jonathan@monarobase.net>
 *
 * (c) 2022 Clarity
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Clarity
 * @package     CurrencyList
 * @copyright   (c) 2022 Clarity <pavels.minckovskis@clarity.cx>
 * @link        https://clarity.cx
 */

use Illuminate\Support\ServiceProvider;

/**
 * CurrencyListServiceProvider
 *
 * @author Clarity <pavels.minckovskis@clarity.cx>
 */
class CurrencyListServiceProvider extends ServiceProvider
{
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
        $this->app->singleton('currencylist', function ($app) {
            return new CurrencyList(base_path('vendor/umpirsky/currency-list/data'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['currencylist'];
    }
}
