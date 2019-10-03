<?php
declare(strict_types=1);

namespace Monarobase\CountryList;

/**
 * This file is part of Monarobase-CountryList
 *
 * (c) 2013 Monarobase
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Monarobase
 * @package     CountryList
 * @copyright   (c) 2013 Monarobase <jonathan@monarobase.net>
 * @link        http://monarobase.net
 */

use Illuminate\Support\Facades\Facade;

/**
 * CountryListFacade
 *
 * @author Monarobase <jonathan@monarobase.net>
 *
 * @method static string getDataDir()
 * @method static string getOne(string $countryCode, string $locale = 'en')
 * @method static array getList(string $locale = 'en', string $format = 'php')
 * @method static CountryList setList(string $locale, array $data)
 * @method static bool has(string $countryCode, string $locale = 'en')
 */
class CountryListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CountryList::class;
    }
}
