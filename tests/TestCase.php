<?php

namespace Pkgdist\Client\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Pkgdist\Client\ClientServiceProvider;

class TestCase extends Orchestra
{
    protected function defineEnvironment($app)
    {
        $app['config']->set('pkgdist-client.endpoint', 'localhost');
    }

    protected function getPackageProviders($app): array
    {
        return [
            ClientServiceProvider::class,
        ];
    }
}
