# Country List

Country List is a package for Laravel 4 which lists all countries with names and ISO 3166-1 codes in all languages and data formats.


## Installation

Add `monarobase/country-list` to `composer.json`.

    "monarobase/country-list": "dev-master"
    
Run `composer update` to pull down the latest version of Country List.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
        'Monarobase\CountryList\CountryListServiceProvider',
    )

Now add the alias.

    'aliases' => array(
        'Countries' => 'Monarobase\CountryList\CountryListFacade',
    )


## Usage

- Locale (en, en_US, fr, fr_CA...)
- Format (csv, flags.html, html, json, mysql.sql, php, postgresql.sql, sqlite.sql, sqlserver.sql, txt, xml, yaml)
- Data source (icu, cldr)

Get all countries

	Route::get('/', function()
	{
		return Countries::getList('en', 'json', 'cldr');
	});


Get one country

	Route::get('/', function()
	{
		return Countries::getOne('RU', 'en', 'cldr');
	});