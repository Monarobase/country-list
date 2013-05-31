<?php namespace Monarobase\CountryList;

use NoiseLabs\Bundle\CountryBundle\CountryManager;

class CountryList extends CountryManager {

    /**
     * Returns one country
     * 
     * @param string $country The country
     * @param string $locale The locale
     * @param string $source Data source: "icu" or "cldr"
     * @return string
     */
    public function getOne($country, $locale = 'en', $source = 'cldr')
    {
        $locales = $this->loadData($locale, strtolower($source));
        return $locales[$country];
    }
}