# Country List

Country List is a package for Laravel 4/5 which lists all countries with names and ISO 3166-1 codes in all languages and data formats.


## Installation

Run `composer require monarobase/country-list` to pull down the latest version of Country List.

Now open up `config/app.php` and add the service provider to your `providers` array.

```php
Monarobase\CountryList\CountryListServiceProvider::class,
```

Now add the alias.

```php
'Countries' => Monarobase\CountryList\CountryListFacade::class,
```

## Usage

- Locale (en, en_US, fr, fr_CA...)
- Format (csv, flags.html, html, json, mysql.sql, php, postgresql.sql, sqlite.sql, sqlserver.sql, txt, xml, yaml)

Get all countries

```php
Route::get('/', function()
{
	return Countries::getList('en', 'json');
});
```

Get one country

```php
Route::get('/', function()
{
	return Countries::getOne('RU', 'en');
});
```