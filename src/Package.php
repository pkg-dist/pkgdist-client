<?php

namespace Pkgdist\Client;

use Composer\IO\BufferIO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\OutputInterface;

class Package
{
    private ?string $package = null;

    public function __construct(string $package)
    {
        $this->package = $package;

        // Boot
        $this->setupAuth();
        $this->setupHttp();
    }

    public function changelogs(): Collection
    {
        return collect();
    }

    private function setupAuth(): void
    {
        $io = new BufferIO('', OutputInterface::VERBOSITY_VERY_VERBOSE);

        $auths = $io->getAuthentications();

        ray($auths);
    }

    private function setupHttp(): void
    {
        $this->client = Http::baseUrl(config('pkgdist-client.endpoint'))
            ->with();
    }

    public static function load(string $package): static
    {
        return new static($package);
    }
}