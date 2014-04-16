<?php
/*
 * This file is part of Monarobase-CountryList
 * Reference : NoiseLabs-CountryBundle by Vítor Brandão <vitor@noiselabs.org>
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

/**
 * CountryList
 *
 * @author Monarobase <jonathan@monarobase.net>
 */
class CountryList {

    /**
     * @var string
     * Path to the directory containing countries data.
     */
    protected $dataDir;

    /**
     * @var array
     * Cached data.
     */
    protected $dataCache = array();

    /**
     * @var array
     * Available data sources.
     */
    protected $dataSources = array('icu', 'cldr');

    /**
     * Constructor.
     *
     * @param string|null $dataDir Path to the directory containing countries data
     */
    public function __construct($dataDir = null)
    {
        if (!isset($dataDir)){
            $r = new \ReflectionClass('Umpirsky\Country\Builder\Builder');
            $dataDir = sprintf('%s/../../../../country', dirname($r->getFileName()));
        }

        if (!is_dir($dataDir)){
            throw new \RuntimeException(sprintf('Unable to locate the country data directory at "%s"', $dataDir));
        }

        $this->dataDir = realpath($dataDir);
    }

    /**
     * @return string The country data directory.
     */
    public function getDataDir()
    {
        return $this->dataDir;
    }

	/**
	 * Returns one country
	 *
	 * @param string $country The country
	 * @param string $locale The locale (default: en)
	 * @param string $format The format (default: php)
	 * @param string $source Data source: "icu" or "cldr"
	 * @return string
	 */
	public function getOne($country, $locale = 'en', $source = 'cldr')
	{
		$locales = $this->loadData($locale, mb_strtolower($source), 'php');
		return $locales[mb_strtoupper($country)];
	}

	/**
	 * Returns a list of countries
	 *
	 * @param string $locale The locale (default: en)
	 * @param string $locale The format (default: php)
	 * @param string $source Data source: "icu" or "cldr"
	 * @return array
	 */
	public function getList($locale = 'en', $format = 'php', $source = 'cldr')
	{
		return $this->loadData($locale, mb_strtolower($source), $format);
	}

    /**
     * @param string $locale The locale
     * @param string $source Data source.
     * @param array $data An array (list) with country data
     */
    public function setList($locale, $source, array $data)
    {
        $this->dataCache[$locale][mb_strtolower($source)] = $data;

        return $this;
    }

	/**
	 * A lazy-loader that loads data from a PHP file if it is not stored in
	 * memory yet.
	 *
	 * @param string $locale The locale
	 * @param string $source Data source.
	 * @param string $locale The format (default: php)
	 * @return array An array (list) with country
	 */
	protected function loadData($locale, $source, $format)
	{
		if (!isset($this->dataCache[$locale][$source][$format])){
			if (!in_array($source, $this->dataSources)){
				throw new \InvalidArgumentException(sprintf('Unknown data source "%s". The available ones are: "%s"', $source, implode('", "', $this->dataSources)));
			}

			$file = sprintf('%s/%s/%s/country.'.$format, $this->dataDir, $source, $locale);
			if (!is_file($file)){
				throw new \RuntimeException(sprintf('Unable to load the country data file "%s"', $file));
			}

			$this->dataCache[$locale][$source][$format] = ($format == 'php') ? require $file : file_get_contents($file);
		}

		return $this->sortData($locale, $this->dataCache[$locale][$source][$format]);
	}

	/**
	 * Sorts the data array for a given locale, using the locale translations.
	 * It is UTF-8 aware if the Collator class is available (requires the intl
	 * extension).
	 *
	 * @param string $locale The locale whose collation rules should be used.
	 * @param array  $data   Array of strings to sort.
	 *
	 * @return array The $data array, sorted.
	 */
	protected function sortData($locale, $data)
	{
		if (is_array($data)){
			if (class_exists('Collator')){
				$collator = new \Collator($locale);
				$collator->asort($data);
			}else{
				asort($data);
			}
		}

		return $data;
	}
}
