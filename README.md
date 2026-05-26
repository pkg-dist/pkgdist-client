# pkgdist-client

PHP client for the [PKG-DIST](https://pkg-dist.com) API. Built for Laravel — auto-discovers, exposes a small `Package` class, and adds an `Http::pkgdist()` macro.

## Requirements

- PHP `^8.2`
- Laravel `^10`, `^11`, `^12`, or `^13`

## Installation

```bash
composer require pkgdist/pkgdist-client
```

The service provider is auto-discovered. No manual registration needed.

### Configuration

Set the endpoint base host in your `.env`:

```dotenv
PKGDIST_CLIENT_ENDPOINT=pkg-dist.com
```

Optionally publish the config to override it directly:

```bash
php artisan vendor:publish --tag=config --provider="Pkgdist\Client\ClientServiceProvider"
```

```php
// config/pkgdist-client.php
return [
    'endpoint' => env('PKGDIST_CLIENT_ENDPOINT'),
];
```

## Usage

### Loading a package

```php
use Pkgdist\Client\Package;

$package = Package::load(
    package: 'vendor/package-name',
    slug: 'your-tenant-slug',
    token: 'your-license-token',
);
```

The `slug` is combined with the configured endpoint to form the API base URL — e.g. `https://your-tenant-slug.pkg-dist.com/api`.

### Fetching changelogs

`changelogs()` returns an `Illuminate\Support\Collection` of `Changelog` objects:

```php
$changelogs = $package->changelogs();

foreach ($changelogs as $changelog) {
    echo $changelog->version;     // e.g. "1.2.0"
    echo $changelog->content;     // markdown release notes
    echo $changelog->created_at;  // ISO-8601 timestamp
}
```

Because it's a Laravel `Collection`, you can chain the usual helpers:

```php
$latest = $package->changelogs()->first();

$recent = $package->changelogs()
    ->sortByDesc('created_at')
    ->take(5);
```

### The `Http::pkgdist()` macro

The service provider registers a macro on Laravel's HTTP client that pre-configures the base URL, so you can make ad-hoc requests against the API without instantiating `Package`:

```php
use Illuminate\Support\Facades\Http;

$response = Http::pkgdist()
    ->withToken($licenseToken)
    ->get('some/endpoint');
```

## Testing

```bash
composer test
```

Tests use [Pest](https://pestphp.com/) and [Orchestra Testbench](https://packages.tools/testbench).

## License

GPL-3.0-only. See [LICENSE](LICENSE).
