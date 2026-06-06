# Lix.li PHP SDK

Official PHP SDK for the [Lix.li](https://Lix.li) API.

[Lix.li](https://lix.li) is a URL shortening and link analytics platform for developers, businesses, and SaaS products.

## Requirements

* PHP 8.2+
* Composer

## Installation

```bash
composer require lix-url/php-sdk
```

## Quick Start

```php
use Lix\Client;

$client = new Client('lix_live_xxx');

$profile = $client->me();
```

### Create a Link

```php
$link = $client->links()->create(
    new CreateLinkRequest(
        url: 'https://example.com'
    )
);
```

### Get a Link

```php
$link = $client->links()->get(123);

echo $link->url;
```

### List Links

```php
$links = $client->links()->list();
```

### Create a Group

```php
$group = $client->groups()->create(
    new CreateGroupRequest(
        name: 'Marketing'
    )
);
```

## Features

* API key authentication
* Links management
* Groups management
* Profile API
* DTO-based responses
* OpenAPI-powered development
* PSR-4 autoloading

## Documentation

* API Documentation: https://lix.li/api
* OpenAPI Specification: https://github.com/lix-url/openapi

## License

MIT
