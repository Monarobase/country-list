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

use Illuminate\Support\Facades\Facade;

/**
 * CurrencyListFacade
 *
 * @author Clarity <pavels.minckovskis@clarity.cx>
 *
 * @method static string getDataDir()
 * @method static string getOne(string $currencyCode, string $locale = 'en')
 * @method static array getList(string $locale = 'en', string $format = 'php')
 * @method static CurrencyList setList(string $locale, array $data)
 * @method static bool has(string $currencyCode, string $locale = 'en')
 */
class CurrencyListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CurrencyList::class;
    }
}
