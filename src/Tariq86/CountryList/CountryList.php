<?php namespace Tariq86\CountryList;

/*
 * This file is part of Tariq86-CountryList
 * Reference : NoiseLabs-CountryBundle by Vítor Brandão <vitor@noiselabs.org>
 *
 * (c) 2016 Tariq86
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 * @category    Tariq86
 * @package     CountryList
 * @copyright   (c) 2013-2015 Tariq86
 */


/**
 * CountryList
 *
 * @author Tariq86
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
	protected $dataCache = [];

	/**
	 * @var array
	 * Available data sources.
	 */
	protected $dataSources = ['icu', 'cldr'];

	/**
	 * Constructor.
	 *
	 * @param string|null $dataDir  Path to the directory containing countries data
	 */
	public function __construct($dataDir = null)
	{
		if ($dataDir === null) {
			$r = new \ReflectionClass(Umpirsky\Country\Builder\Builder::class);
			$dataDir = sprintf('%s/../../../../country', dirname($r->getFileName()));
		}

		if (!is_dir($dataDir)) {
			throw new \RuntimeException(sprintf('Unable to locate the country data directory at "%s"', $dataDir));
		}

		$this->dataDir = realpath($dataDir);
	}

	/**
	 * @return string  The country data directory.
	 */
	public function getDataDir()
	{
		return $this->dataDir;
	}

	/**
	 * Returns one country.
	 *
	 * @param string $countryCode  The country
	 * @param string|null $locale       The locale (default: null, which will get the current app locale)
	 * @param string $source       Data source: "icu" or "cldr"
	 * @return string
	 * @throws CountryNotFoundException  If the country code doesn't match any country.
	 */
	public function getOne($countryCode, $locale = null, $source = 'cldr')
	{
		$locale = $this->_getLocale($locale);
		$countryCode = mb_strtoupper($countryCode);
		$locales = $this->loadData($locale, mb_strtolower($source), 'php');

		if (!$this->has($countryCode, $locale, $source))
		{
			throw new CountryNotFoundException($countryCode);
		}

		return $locales[mb_strtoupper($countryCode)];
	}

	/**
	 * Returns a list of countries.
	 *
	 * @param string $locale  The locale (default: en)
	 * @param string $format  The format (default: php)
	 * @param string $source  Data source: "icu" or "cldr"
	 * @return array
	 */
	public function getList($locale = null, $format = 'php', $source = 'cldr')
	{
		$locale = $this->_getLocale($locale);
		return $this->loadData($locale, mb_strtolower($source), $format);
	}

	/**
	 * @param string $locale  The locale
	 * @param string $source  Data source
	 * @param array $data     An array (list) with country data
	 * @return CountryList    The instance of CountryList to enable fluent interface
	 */
	public function setList($locale, $source, array $data)
	{
		$locale = $this->_getLocale($locale);
		$this->dataCache[$locale][mb_strtolower($source)] = $data;

		return $this;
	}

	/**
	 * A lazy-loader that loads data from a PHP file if it is not stored in memory yet.
	 *
	 * @param string $locale  The locale
	 * @param string $source  Data source
	 * @param string $format  The format (default: php)
	 * @return array          An array (list) with country
	 */
	protected function loadData($locale, $source, $format)
	{
		$locale = $this->_getLocale($locale);
		if (!isset($this->dataCache[$locale][$source][$format])) {
			if (!in_array($source, $this->dataSources)) {
				throw new \InvalidArgumentException(sprintf('Unknown data source "%s". The available ones are: "%s"', $source, implode('", "', $this->dataSources)));
			}

			$file = sprintf('%s/%s/%s/country.'.$format, $this->dataDir, $source, $locale);

			if (!is_file($file)) {
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
	 * @param string $locale  The locale whose collation rules should be used.
	 * @param array  $data    Array of strings to sort.
	 * @return array          The $data array, sorted.
	 */
	protected function sortData($locale, $data)
	{
		$locale = $this->_getLocale($locale);
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
	 * @param string $locale       The locale (default: null, which will get current app locale)
	 * @param string $source       Data source: "icu" or "cldr"
	 * @return bool                <code>true</code> if a match was found, <code>false</code> otherwise
	 */
	public function has($countryCode, $locale = null, $source = 'cldr')
	{
		$locale = $this->_getLocale($locale);
		$locales = $this->loadData($locale, mb_strtolower($source), 'php');

		return isset($locales[mb_strtoupper($countryCode)]);
	}


	private function _getLocale($locale) {
		if ($locale === null) {
			$locale = \App::getLocale();
		}
		return $locale;
	}
}
