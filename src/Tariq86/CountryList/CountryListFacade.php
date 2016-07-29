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

use Illuminate\Support\Facades\Facade;

/**
 * CountryListFacade
 *
 * @author Tariq86
 */
class CountryListFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'countrylist'; }

}
