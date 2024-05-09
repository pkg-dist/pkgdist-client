<?php

namespace Pkgdist\Client;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pkgdist-client.php', 'pkgdist-client');
    }

    public function boot(): void
    {
        $this->setupHttp();
    }

    private function setupHttp(): void
    {
        Http::macro('pkgdist', function () {
            return Http::baseUrl(config('pkgdist-client.url'));
        });
    }
}