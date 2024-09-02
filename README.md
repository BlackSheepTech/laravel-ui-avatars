<p align="center">
    <a href="https://github.com/BlackSheepTech/ui-avatars" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/85756821?s=400&u=14843f72938dc40cbd14400f5b3daad45f054f43&v=4" width="200" alt="BlackSheepTech UiAvatars">
    </a>
</p>

<p align="center">
    <a href="https://packagist.org/packages/black-sheep-tech/ui-avatars"><img src="https://img.shields.io/packagist/v/black-sheep-tech/ui-avatars" alt="Current Version"></a>
    <a href="https://packagist.org/packages/black-sheep-tech/ui-avatars"><img src="https://img.shields.io/packagist/dt/black-sheep-tech/ui-avatars" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/black-sheep-tech/ui-avatars"><img src="https://img.shields.io/github/license/BlackSheepTech/ui-avatars" alt="License"></a>
    <a href="https://packagist.org/packages/black-sheep-tech/ui-avatars"><img src="https://img.shields.io/github/stars/BlackSheepTech/ui-avatars" alt="Stars"></a>
</p>

UiAvatars is a PHP library for Laravel used to generate avatar using the UI Avatars API (https://ui-avatars.com).
This package provides a simple, fluent interface for customizing avatar parameters and generating the corresponding URL. It also allows downloading and saving the avatars locally.

## Installation

You can install the package via Composer:

```bash
composer require black-sheep-tech/ui-avatars
```

## Usage

### Basic Usage / Url Generation

```php
use BlackSheepTech\UiAvatars\UiAvatars;

$avatarUrl = UiAvatars::make()
    ->name('John Doe')
    ->size(128)
    ->background('#ffffff')
    ->color('#000000')->getUrl();
```

### With all customizations

```php

$avatarUrl = UiAvatars::make()
    ->name('John Doe')
    ->size(128)
    ->background('#ffffff')
    ->color('#000000')
    ->length(2)
    ->rounded(true)
    ->bold(true)
    ->uppercase(true)
    ->format('png')
    ->getUrl();
```

### Download Avatar

To download the avatar directly:

```php
use BlackSheepTech\UiAvatars\UiAvatars;

// Prompts a download of the avatar to a file named 'john_doe_avatar.png', by default, if a file name is not provided, a random name will be generated.

UiAvatars::make()->name('John Doe')->download('john_doe_avatar');
```

### Save Avatar Directly to Disk

To save the avatar to a specific location:

```php
use BlackSheepTech\UiAvatars\UiAvatars;

// Saves the avatar to 'avatars/john_doe_avatar.png' by default.
$avatarPath = UiAvatars::make()->name('John Doe')->saveTo('avatars', 'john_doe_avatar');

// You can provided the disk to be used as the third parameter, by default, the application's default disk will be used.
$avatarPath = UiAvatars::make()->name('John Doe')->saveTo('avatars', 'john_doe_avatar', 'public');
```

## Customization

The `UiAvatarsService` class allows for various customizations:

- **name**: Sets the name from which the initials are generated.
- **background**: Sets the background color (hex code or 'random')(default: random).
- **color**: Sets the font color (hex code)(default: 8b5d5d).
- **size**: Sets the size of the avatar in pixels (16 to 512)(default: 64).
- **fontSize**: Sets the font size ratio (0.1 to 1.0)(default: 0.5).
- **length**: Sets the number of characters for initials (default: 2).
- **rounded**: Enables rounded avatars (default: false).
- **bold**: Enables bold text for initials (default: false).
- **uppercase**: Converts initials to uppercase (default: true).
- **format**: Sets the format of the avatar ('png' or 'svg')(default: png).

## Requirements

- PHP 8.0 or higher
- Laravel framework version 9.0 or higher

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request on GitHub.

## Credits

- [Israel Pinheiro](https://github.com/IsraelPinheiro)
- [All Contributors](https://github.com/BlackSheepTech/ui-avatars/graphs/contributors)
