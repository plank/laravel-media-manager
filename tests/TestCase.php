<?php

namespace Plank\MediaManager\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Plank\MediaManager\MediaManagerServiceProvider;

abstract class TestCase extends Orchestra
{
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
            MediaManagerServiceProvider::class
        ];
    }
}
