<?php
 /*
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

namespace Monarobase\CountryList;

use Illuminate\Support\Facades\Facade;

/**
 * CountryListFacade
 *
 * @author Monarobase <jonathan@monarobase.net>
 */ 
class CountryListFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'countrylist'; }
 
}