<?php namespace Monarobase\CountryList;
 
use Illuminate\Support\Facades\Facade;
 
class CountryListFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'countrylist'; }
 
}