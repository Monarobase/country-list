# Country List

Currency List is a package for Laravel which lists all currencies with names and ISO 4217 codes in all languages and data formats.


## Installation

Run `composer require pminckovskis/currency-list`.

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

If you don't use auto-discovery, add the ServiceProvider to the `providers` array in `config/app.php`

```php
Clarity\CurrencyList\CurrencyListServiceProvider::class,
```

If needed, add the following alias as well.

```php
'Currencies' => Clarity\CurrencyList\CurrencyListFacade::class,
```

## Usage

- Locale (en, en_US, fr, fr_CA...)
- Format (csv, flags.html, html, json, mysql.sql, php, postgresql.sql, sqlite.sql, sqlserver.sql, txt, xml, yaml)

Get all currencies

```php
Route::get('/', function()
{
	return Currencies::getList('en', 'json');
});
```

Get one currency

```php
Route::get('/', function()
{
	return Currencies::getOne('USD', 'en');
});
```