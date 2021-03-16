# Laravel Media Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/plank/media-manager.svg?style=flat-square)](https://packagist.org/packages/plank/media-manager)
[![Build Status](https://img.shields.io/travis/plank/media-manager/master.svg?style=flat-square)](https://travis-ci.org/plank/media-manager)
[![Quality Score](https://img.shields.io/scrutinizer/g/plank/media-manager.svg?style=flat-square)](https://scrutinizer-ci.com/g/plank/media-manager)
[![Total Downloads](https://img.shields.io/packagist/dt/plank/media-manager.svg?style=flat-square)](https://packagist.org/packages/plank/media-manager)

This package builds upon [Laravel-Mediable](https://github.com/plank/laravel-mediable) with an API implementing it, as well as a set of VueJS components that can be dropped anywhere on your site
for an instant media manager. 

## Installation

You can install the package via composer:

```shell script
composer require plank/media-manager
```

You'll need to publish the assets from the package for use in your project, as well as the config file
```shell script
php artisan vendor:publish --tag=manager-assets --tag=manager-config
```

Since this package integrates tightly with [Laravel-Mediable](https://github.com/plank/laravel-mediable), you should
publish that config file as well.

```shell script
php artisan vendor:publish --provider="Plank\Mediable\MediableServiceProvider"
```

Run the migrations to add the required tables to your database:

```shell script
php artisan migrate
``` 

## Usage

``` php
// Usage description here
```

### Testing

``` bash
composer test
```

## Dependencies

The Vue components included with this package have a number of dependencies that to ease development. 
A huge thanks to their creators. 

| Name | Function | Credit |
| --- | --- | --- |
| [vue-dropzone](https://rowanwins.github.io/vue-dropzone/) | Uploading Files | [Rowan Winsemius](https://github.com/rowanwins) |
| [vuedraggable](https://sortablejs.github.io/Vue.Draggable/#/simple) | Drag & Drop Folders and Files | [SortableJS](https://github.com/SortableJS) |
|     |     |      |


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email massimo@plankdesign.com instead of using the issue tracker.

## Credits

- [Massimo Triassi](https://github.com/m-triassi)
- [Evan Dimopoulos](https://github.com/EvanDime)
- [Jerome Devillers](https://github.com/JeromeDevillers/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
