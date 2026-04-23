# Stagebox

[![Tests](https://github.com/MimisK13/laravel-stagebox/actions/workflows/tests.yml/badge.svg)](https://github.com/MimisK13/laravel-stagebox/actions/workflows/tests.yml)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

`mimisk/stagebox` is a Laravel package for managing stagebox records with built-in migrations and automatic slug generation.

## Installation

Via Composer

```bash
composer require mimisk/stagebox
```

## Usage

This package provides:
- `Mimisk\Stagebox\Models\Stagebox` Eloquent model
- internal package migration for the `stageboxes` table
- owner-scoped stageboxes via polymorphic relation (`stageboxable_type` / `stageboxable_id`)

Run migrations:

```bash
php artisan migrate
```

Use the model:

```php
use Mimisk\Stagebox\Models\Stagebox;

$stagebox = Stagebox::create([
    'name' => 'A',
    'channels' => 12,
    'returns' => 4,
    'color' => 'brown',
    'notes' => 'Drum Riser',
]);
```

The `slug` is generated automatically from `name` when not provided.

Fields:
- `name` (string)
- `slug` (unique per owner scope)
- `channels` (unsigned tiny integer)
- `returns` (unsigned tiny integer, default `0`)
- `color` (string, default `black`)
- `notes` (nullable text)
- `timestamps`

Query examples:

```php
use Mimisk\Stagebox\Models\Stagebox;

$all = Stagebox::orderBy('name')->get();
$single = Stagebox::where('slug', 'a')->first();
```

## Testing

```bash
composer test
```

## Credits

- [MimisK13][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mimisk/stagebox.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mimisk/stagebox.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/MimisK13/laravel-stagebox/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/mimisk/stagebox
[link-downloads]: https://packagist.org/packages/mimisk/stagebox
[link-travis]: https://travis-ci.org/MimisK13/laravel-stagebox
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/MimisK13
[link-contributors]: https://github.com/MimisK13/laravel-stagebox/contributors
