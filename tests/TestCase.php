<?php

namespace Pkgdist\Client\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Pkgdist\Client\ClientServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ClientServiceProvider::class,
        ];
    }
}
