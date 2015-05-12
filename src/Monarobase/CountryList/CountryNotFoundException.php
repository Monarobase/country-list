<?php namespace Monarobase\CountryList;

/**
 * CountryNotFoundException.php
 * 
 * @author Yohann Bianchi<yohann.b@lahautesociete.com>
 * @since 12/05/15
 * @copyright 2015 La Haute Société - http://www.lahautesociete.com/
 */


class CountryNotFoundException extends \Exception{

	/**
	 * Constructor.
	 * 
	 * @param string $countryCode  A 2-letter country code
	 */
	public function __construct($countryCode)
	{
		parent::__construct('Country "'.$countryCode.'" not found.');
	}

}