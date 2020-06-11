<?php

namespace Plank\MediaManager\Tests;

use Orchestra\Testbench\TestCase;
use Plank\MediaManager\MediaManagerServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [MediaManagerServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
