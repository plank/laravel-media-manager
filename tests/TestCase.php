<?php

namespace Plank\MediaManager\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Plank\Mediable\MediableServiceProvider;
use Plank\MediaManager\MediaManagerServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom([
            '--path' => dirname(__DIR__, 1) . '/vendor/plank/laravel-mediable/migrations',
            '--database' => 'sqlite'
        ]);
        $this->loadMigrationsFrom([
            '--path' => dirname(__DIR__, 1) . '/database/migrations',
            '--database' => 'sqlite'
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('mediamanager.enabled', true);
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);

        /*
        * Filesystems that can be used for media storage
        */
        $app['config']->set('mediable.allowed_disks', [
            'uploads',
            'local',
            's3',
        ]);
    }

    /**
     * Ignore package discovery from.
     *
     * @return array<int, string>
     */
    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            MediaManagerServiceProvider::class,
            MediableServiceProvider::class,
        ];
    }
}
