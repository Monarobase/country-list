<?php
declare(strict_types=1);

namespace Clarity\CurrencyList;

/**
 * CurrencyNotFoundException
 *
 * @author Clarity <pavels.minckovskis@clarity.cx>
 * @copyright (c) 2022 Clarity <pavels.minckovskis@clarity.cx>
 */
class CurrencyNotFoundException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $currencyCode  A 3-letter country code
     */
    public function __construct($currencyCode)
    {
        parent::__construct('Currency "' . $currencyCode . '" not found.');
    }
}
