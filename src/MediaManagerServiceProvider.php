<?php

namespace Plank\MediaManager;

use Plank\MediaManager\Commands\GenerateConversions;
use Plank\MediaManager\Commands\InstallManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Config;
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
        if (!defined('MANAGER_PATH')) {
            define('MANAGER_PATH', realpath(__DIR__.'/../'));
        }

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'media-manager');
         $this->loadMigrationsFrom(MANAGER_PATH.'/database/migrations');
        if (MediaManager::$registerRoutes) {
            $this->loadRoutesFrom(MANAGER_PATH.'/routes/web.php');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                MANAGER_PATH.'/config/config.php' => config_path('media-manager.php'),

            ], 'manager-config');

            $this->publishes([
                MANAGER_PATH.'/resources/js' => resource_path('assets/plank/laravel-media-manager')],
                'vue-components');

            $this->publishes([
                MANAGER_PATH.'/public' => public_path('vendor/laravel-media-manager'),
            ], 'manager-assets');


            // Registering package commands.
             $this->commands([InstallManager::class, GenerateConversions::class]);

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('MANAGER_PATH')) {
            define('MANAGER_PATH', realpath(__DIR__.'/../'));
        }

        // Automatically apply the package configuration
        $this->mergeConfigFrom(MANAGER_PATH.'/config/media-manager.php', 'media-manager');
        // Make sure Mediable uses this packages model instead
        Config::set('mediable.model', config('media-manager.model'));

        // Register the main class to use with the facade
        $this->registerMediaManager();
        $this->registerMediaManagerController();
        $this->registerMediaController();
    }

    public function registerMediaManager()
    {
        $this->app->bind('media-manager', function (Container $app) {
            return new MediaManager(config('media-manager.model'));
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
            return new MediaController($app['mediable.uploader']);
        });
    }
}
