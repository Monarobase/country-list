# Country List

Country List is a package for Laravel 4 & 5, which lists all countries with names and ISO 3166-1 codes in all languages and data formats.


## Installation

Add `Tariq86/country-list` to `composer.json`.

    "Tariq86/country-list": "^1.0.0"

Run `composer update` to pull down the latest version of Country List.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

```php
    'providers' => [
        Tariq86\CountryList\CountryListServiceProvider::class,
    ]
```

Now add the alias.
```php
    'aliases' => [
        'Countries' => Tariq86\CountryList\CountryListFacade::class
    ]
```

## Usage

- Locale (en, en_US, fr, fr_CA...)
- Format (csv, flags.html, html, json, mysql.sql, php, postgresql.sql, sqlite.sql, sqlserver.sql, txt, xml, yaml)
- Data source (icu, cldr)

Get all countries
```php
	Route::get('/', function()
	{
		return Countries::getList('en', 'json', 'cldr');
	});
```

Get one country
```php
	Route::get('/', function()
	{
		return Countries::getOne('RU', 'en', 'cldr');
	});
```
