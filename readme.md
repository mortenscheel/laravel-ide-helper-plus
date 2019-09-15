# Laravel IDE Helper Plus

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This package is an extension for Barry vd. Heuvel's [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper), adding some convenient automation features:
* If an Eloquent model's underlying table is modified through a migration, automatically execute `php artisan ide-helper:models App\AffectedModel` after the migration has completed.

* Automatically execute `php artisan ide-helper:generate` and/or `php artisan ide-helper:meta` when composer packages are changed (without having to edit the scripts in `composer.json`)

I've submitted a  [pull-request](https://github.com/barryvdh/laravel-ide-helper/pull/797) adding these features to the original package, but since there has been no response in several months, I've decided to release them as a separate package.



## Installation

Via Composer

``` bash
$ composer require --dev mortenscheel/laravel-ide-helper-plus
```

Publish config

``` bash
$ php artisan vendor:publish --tag ide-helper-plus
```

Default configuration
``` php
<?php

return [
    'auto-docblocks' => [
        'enabled' => env('AUTO_MODEL_DOCBLOCKS', false),
        'options' => [
            '--write'       => true,
            '--smart-reset' => true,
        ],
    ],
    'auto-generate' => [
        'enabled' => env('AUTO_IDE_HELPER_GENERATE', false),
    ],
    'auto-meta' => [
        'enabled' => env('AUTO_IDE_HELPER_META', false),
    ]
];
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Barry vd. Heuvel](https://github.com/barryvdh) (author of Laravel IDE Helper)
- [Morten Scheel][link-author] (automation features)

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mortenscheel/laravel-ide-helper-plus.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mortenscheel/laravel-ide-helper-plus.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mortenscheel/laravel-ide-helper-plus
[link-downloads]: https://packagist.org/packages/mortenscheel/laravel-ide-helper-plus
[link-author]: https://github.com/mortenscheel
