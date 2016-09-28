# Personal ID Validator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Library to validate personal IDs of different countries. Most of the countries in the world assign certain ID to each citizen. 
This library helps to validate it. One just need to pass ID and country short-name (in [ISO 3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1) standard) to the validator.
  
Supported countries (in alphabetical order):

| Country code  | Country name | Personal ID name |
| ------------- | ------------ | ---------------- |
| DK | Denmark | CPR-nummer |
| FI | Finland | HETU |
| PL | Poland  | PESEL |
| SE | Sweden  | Personnumer |

## Install

Via Composer

``` bash
$ composer require cyrkulewski/personal-id-validator
```

## Usage
There is one public function used for validation. It will return boolean. One need to pass ID to check and country code.
``` php
$validator->validate('ID', 'COUNTRY');
```

``` php
use cyrkulewski\PIdV\PIdValidator;

$validator = new PIdValidator();
$validator->validate('197704190011', 'SE'); // true
$validator->validate('311280-888Y', 'FI'); // true
$validator->validate('abcdef', 'DK'); // false
$validator->validate('197704190011', 'NON-SUPPORTED-COUNTRY'); // false
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email cyrkulewski@gmail.com instead of using the issue tracker.

## Credits

- [Aleksander Cyrkulewski][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cyrkulewski/personal-id-validator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/cyrkulewski/personal-id-validator/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/cyrkulewski/personal-id-validator.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cyrkulewski/personal-id-validator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cyrkulewski/personal-id-validator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cyrkulewski/personal-id-validator
[link-travis]: https://travis-ci.org/cyrkulewski/personal-id-validator
[link-scrutinizer]: https://scrutinizer-ci.com/g/cyrkulewski/personal-id-validator/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/cyrkulewski/personal-id-validator
[link-downloads]: https://packagist.org/packages/cyrkulewski/personal-id-validator
[link-author]: https://github.com/martyshka
