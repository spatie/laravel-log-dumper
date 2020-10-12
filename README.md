# A function to dump anything to the log

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-log-dumper.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-log-dumper)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-log-dumper/run-tests?label=tests)](https://github.com/spatie/laravel-log-dumper/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-log-dumper.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-log-dumper)

This package contains a function `ld`. Any argument you pass to it will be dumped to the log. You can pass any kind of value to it.

```php
ld('a string', ['an array'], new Class());
```

Under the hood, Symfony's `VarDumper` is used to create string representations.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-log-dumper.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-log-dumper)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-log-dumper
```

## Usage

You can pass any variable you want to `ld`.

```php
ld('a string', ['an array'], new Class());
```

All arguments will be converted to strings and will be written to the application log using the `info` level.

## Using other log levels

If you want to use another log level, you can just call the method you want on `ld`. You can pass these methods any type of argument and any number of arguments. They will all be logged.

```php
// logs using the `error` level
ld()->error('a string', ['an array'], new Class())
```

Of course, you can mix and chain different levels.

```php
ld()
   ->debug('Debug info', ['an array'])
   ->error('Error info', new Class);
```

## Enabling and disabling logging

You can disable logging by calling `disable`.

```php
ld('foo'); // will be logged

ld()->disable();

ld('bar'); // will not be logged

ld()->enable();

ld('baz'); // will be logged
```

You can pass a boolean to `enable`. This can be handy when you want to log only one iteration of a loop.

```php
foreach (range(1, 3) as $i) {
   // only things in the third iteration will be logged
   ld()->enable($i === 3);

   ld('we are in the third iteration');
}
```

## Logging queries

You can log all queries with `logQueries`.

````php
ld()->logQueries(); // all queries after this call will be logged
````

If you wish to stop logging queries, call `stopLoggingQueries`.

````php
ld()->stopLoggingQueries(); // all queries after this call will not be logged anymore
````

Alternatively to manually starting and stopping listening for queries, you can also pass a closure to `logQueries`. Only the queries executed inside the closure will be logged.

````php
ld()->logQueries(function() {
    $this->mailAllUsers(); // all queries executed in this closure will be logged
});

User::get(); // this query will not be logged
````

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
