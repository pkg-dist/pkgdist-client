<?php

use Pkgdist\Client\Package;

it('can boot for a package', function () {
    $packageName = 'composer/composer';
    $token = fake()->uuid();

    $package = Package::load($packageName, $token);

    expect($package)
        ->toBeInstanceOf(Package::class);
});
