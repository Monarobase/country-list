<?php
declare(strict_types=1);

namespace Monarobase\CountryList;

/**
 * This file is part of Monarobase-CountryList
 * Reference : NoiseLabs-CountryBundle by Vítor Brandão <vitor@noiselabs.org>
 *
 * (c) 2013-2015 Monarobase
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Monarobase
 * @package     CountryList
 * @copyright   (c) 2013-2015 Monarobase <jonathan@monarobase.net>
 * @link        https://monarobase.net
 */

/**
 * CountryList
 *
 * @author Monarobase <jonathan@monarobase.net>
 */
class CountryList
{
    /**
     * Path to the directory containing countries data.
     * @var string
     */
    protected $dataDir;

    /**
     * Cached data.
     * @var array
     */
    protected $dataCache = [];

    /**
     * Constructor.
     *
     * @param string|null $dataDir  Path to the directory containing countries data
     */
    public function __construct(?string $dataDir = null)
    {
        if (!isset($dataDir)) {
            $dataDir = base_path('vendor/umpirsky/country-list/data');
        }

        if (!is_dir($dataDir)) {
            throw new \RuntimeException(sprintf('Unable to locate the country data directory at "%s"', $dataDir));
        }

        $this->dataDir = realpath($dataDir);
    }

    /**
     * Get the country data directory.
     *
     * @return string
     */
    public function getDataDir(): string
    {
        return $this->dataDir;
    }

    /**
     * Returns one country.
     *
     * @param string $countryCode  The country
     * @param string $locale       The locale (default: en)
     * @return string
     * @throws CountryNotFoundException  If the country code doesn't match any country.
     */
    public function getOne(string $countryCode, string $locale = 'en'): string
    {
        $countryCode = mb_strtoupper($countryCode);
        $locales = $this->loadData($locale, 'php');

        if (!$this->has($countryCode, $locale)) {
            throw new CountryNotFoundException($countryCode);
        }

        return $locales[mb_strtoupper($countryCode)];
    }

    /**
     * Returns a list of countries.
     *
     * @param string $locale  The locale (default: en)
     * @param string $format  The format (default: php)
     * @return mixed          An array (list) with country or raw data
     */
    public function getList(string $locale = 'en', string $format = 'php')
    {
        return $this->loadData($locale, $format);
    }

    /**
     * @param string $locale  The locale
     * @param array $data     An array (list) with country data
     * @return CountryList    The instance of CountryList to enable fluent interface
     */
    public function setList(string $locale, array $data): CountryList
    {
        $this->dataCache[$locale] = $data;

        return $this;
    }

    /**
     * A lazy-loader that loads data from a PHP file if it is not stored in memory yet.
     *
     * @param string $locale  The locale
     * @param string $format  The format (default: php)
     * @return mixed          An array (list) with country or raw data
     */
    protected function loadData(string $locale, string $format)
    {
        $locale = str_replace('-', '_', $locale);

        if (!isset($this->dataCache[$locale][$format])) {
            // Customization - "source" does not matter anymore because umpirsky refactored his library.
            $file = sprintf('%s/%s/country.%s', $this->dataDir, $locale, $format);

            if (!is_file($file)) {
                throw new \RuntimeException(sprintf('Unable to load the country data file "%s"', $file));
            }

            $this->dataCache[$locale][$format] = ($format === 'php') ? require $file : file_get_contents($file);
        }

        return $this->sortData($locale, $this->dataCache[$locale][$format]);
    }

    /**
     * Sorts the data array for a given locale, using the locale translations.
     * It is UTF-8 aware if the Collator class is available (requires the intl
     * extension).
     *
     * @param string $locale  The locale whose collation rules should be used.
     * @param mixed  $data    Array of strings or raw data.
     * @return mixed          If $data is an array, it will be sorted, otherwise raw data
     */
    protected function sortData(string $locale, $data)
    {
        if (is_array($data)) {
            if (class_exists('Collator')) {
                $collator = new \Collator($locale);
                $collator->asort($data);
            } else {
                asort($data);
            }
        }

        return $data;
    }

    /**
     * Indicates whether or not a given $countryCode matches a country.
     *
     * @param string $countryCode  A 2-letter country code
     * @param string $locale       The locale (default: en)
     * @return bool                <code>true</code> if a match was found, <code>false</code> otherwise
     */
    public function has(string $countryCode, string $locale = 'en'): bool
    {
        $locales = $this->loadData($locale, 'php');

        return isset($locales[mb_strtoupper($countryCode)]);
    }
}
