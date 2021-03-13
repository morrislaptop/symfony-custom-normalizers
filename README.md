# Normalizers for common classes around the place

[![Latest Version on Packagist](https://img.shields.io/packagist/v/morrislaptop/symfony-custom-normalizers.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/symfony-custom-normalizers)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/morrislaptop/symfony-custom-normalizers/Tests?label=tests)](https://github.com/morrislaptop/symfony-custom-normalizers/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/morrislaptop/symfony-custom-normalizers.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/symfony-custom-normalizers)


A collection of normalizers that can be used with the Symfony serializer.

## Installation

You can install the package via composer:

```bash
composer require morrislaptop/symfony-custom-normalizers
```

## Usage

```php
$serializer = new Symfony\Serializer([
    new Morrislaptop\SymfonyCustomNormalizers\MoneyNormalizer(),
    new Morrislaptop\SymfonyCustomNormalizers\DatePeriodNormalizer(),
    ...
])
```

## Plug

Use Laravel? Easily cast your objects using the Symfony serializer with [morrislaptop/laravel-popo-caster](https://github.com/morrislaptop/laravel-popo-caster)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Craig Morris](https://github.com/morrislaptop)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
