# Laravel Media Manager

[comment]: <> ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/plank/media-manager.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/plank/media-manager&#41;)

[comment]: <> ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/workflow/status/plank/laravel-checkpoint/tests?label=tests&#41;]&#40;https://github.com/plank/laravel-media-manager/actions?query=workflow%3Atests+branch%3Amaster&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/plank/media-manager.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/plank/media-manager&#41;)

⚠️ This package is not ready for public use ⚠️

This package builds upon [Laravel-Mediable](https://github.com/plank/laravel-mediable) with an API implementing it, 
as well as adding a set of VueJS components that can be dropped anywhere on your site for an instant media manager. 

## Installation

You can install the package via composer:

```shell script
composer require plank/media-manager
```

Since this package integrates tightly with [Laravel-Mediable](https://github.com/plank/laravel-mediable), you should
publish that config file and migration.

```shell script
php artisan vendor:publish --provider="Plank\Mediable\MediableServiceProvider"
```

Then install the media manager to compile with your Mix pipeline, as well as install front end dependencies and build assets

_Note:_ This will install Vue@2.6, among other dependencies as well as append the appropriate directives to your
`webpack.mix.js` file, making the Vue components accessible universally.

```shell script
php artisan manager:install
```

Follow the prompts provided by the command, and once complete the media manager will be compiled along with your application
any time you run `npm run dev`

Finally, You'll want to publish the config from the package for use in your project, as well as, optionally, the assets
```shell script
php artisan vendor:publish --tag=manager-config [--tag=manager-assets]
```

Run the migrations to add the required tables to your database:

```shell script
php artisan migrate
```

## Usage
By default the main component is set to mount on an element with the id `#media-manager`. Simply create an element, say
a `<div>` with this id, and link to the applications `app.js` and `app.css` files, and the component should render.
For example your blade file might look something like this:

```html
<head>
    <link href="{{ mix('css/app.css') }}">
</head>
<body>

<div class="app-container">
    <div></div>
    <div id="media-manager"></div>
</div>

<script src="{{ mix('js/app.js')}} "></script>

</body>

```

_Note:_ The style sheets for this package include an "app container" class, for ease of use, but you don't need to use that.

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
| [vue-i18n](https://kazupon.github.io/vue-i18n/) | Translation strings via JSON | [Kazuya Kawaguchi](https://github.com/kazupon) |
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
