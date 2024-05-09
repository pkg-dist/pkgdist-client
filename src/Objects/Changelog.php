<?php

namespace Pkgdist\Client\Objects;

class Changelog
{
    private array $definition = [
        'version',
        'content',
        'created_at',
    ];

    private array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get(string $name)
    {
        return $this->attributes[$name];
    }

    public function __isset(string $name): bool
    {
        return in_array($name, $this->definition);
    }
}