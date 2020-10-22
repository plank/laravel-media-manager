<?php

namespace Plank\MediaManager;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Plank\MediaManager\Http\Controllers\MediaController;
use Plank\MediaManager\Http\Controllers\MediaManagerController;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'media-manager');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'media-manager');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/media-manager.php' => config_path('media-manager.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/media-manager'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/media-manager'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/media-manager'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/media-manager.php', 'media-manager');
        // TODO: Find a cleaner way to achieve this
        // Make sure Mediable uses this packages model instead
        config(['mediable.model' => config('media-manager.model')]);

        // Register the main class to use with the facade
        $this->registerMediaManager();
        $this->registerMediaManagerController();
        $this->registerMediaController();

    }

    public function registerMediaManager()
    {
        $this->app->bind('media-manager', function (Container $app) {
            return new MediaManager;
        });
    }

    public function registerMediaManagerController()
    {
        $this->app->bind('MediaManagerController', function (Container $app) {
            return new MediaManagerController($app['media-manager']);
        });
    }

    public function registerMediaController()
    {
        $this->app->bind('MediaController', function (Container $app) {
            return new MediaController($app['mediable.uploader'], $app['mediable.mover']);
        });
    }

}
