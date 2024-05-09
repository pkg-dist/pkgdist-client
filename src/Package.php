<?php

namespace Pkgdist\Client;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pkgdist\Client\Objects\Changelog;

class Package
{
    private string $slug;

    private string $package;

    private string $token;

    public function __construct(string $package, string $slug, ?string $token = null)
    {
        $this->package = $package;
        $this->slug = $slug;
        $this->token = $token;

        // Boot
        $this->setupHttp();
    }

    public function changelogs(): Collection
    {
        $changelogs = $this->client->get('changelogs', ['license' => $this->token]);

        if (!$changelogs->status() === 200) {
            throw new \Exception('Could not retrieve changelogs.');
        }

        return collect($changelogs->json('data'))->map(fn(array $changelog) => new Changelog($changelog));
    }

    private function setupHttp(): void
    {
        $slug = $this->slug;
        $endpoint = config('pkgdist-client.endpoint');

        $this->client = Http::baseUrl("{$slug}.{$endpoint}/api");
    }

    public static function load(string $package, string $slug, string $token): static
    {
        return new static($package, $slug, $token);
    }
}