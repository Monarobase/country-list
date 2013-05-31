# Country List

Country List is a package for Laravel 4 which lists all countries with names and ISO 3166-1 codes in all languages and data formats.


## Requirements

You need [umpirsky/country-list](https://github.com/umpirsky/country-list) and [noiselabs / NoiselabsCountryBundle](https://github.com/noiselabs/NoiselabsCountryBundle)

Update your composer.json with :

    "umpirsky/country-list": "dev-master",
    "noiselabs/country-bundle": "dev-master"


## Installation

Add `monarobase/country-list` to `composer.json`.

    "monarobase/country-list": "dev-master"
    
Run `composer update` to pull down the latest version of Country List.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
        'Monarobase\CountryList\CountryListServiceProvider'
    )

Now add the alias.

    'aliases' => array(
        'Countries' => 'Monarobase\CountryList\CountryListFacade',
    )
