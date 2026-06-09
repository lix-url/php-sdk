# Lix.li PHP SDK

Official PHP SDK for the Lix.li API.

[Lix.li](https://lix.li) is a URL shortening and link analytics platform with support for custom aliases, groups, tags, UTM parameters and detailed click tracking.

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
$link = $client->links()->create('https://example.com');
echo $link->link->shortUrl;
```

## Profile

Get information about the authenticated account.

```php
$profile = $client->profile()->get();

echo $profile->user->email;
```

## Links

### Create a Link

```php
$link = $client->links()->create(
    url: 'https://example.com'
);

echo $link->link->shortUrl;
```

### Create a Link with Custom Alias

```php
$link = $client->links()->create(
    url: 'https://example.com',
    alias: 'my-link'
);
```

### Create a Link with UTM Parameters

```php
$link = $client->links()->create(
    url: 'https://example.com',
    utm: [
        'source' => 'newsletter',
        'medium' => 'email',
        'campaign' => 'summer-sale',
    ]
);
```

### Get a Link

```php
$link = $client->links()->get(123);

echo $link->url;
echo $link->shortUrl;
```

### Update a Link

```php
$link = $client->links()->update(
    id: 123,
    title: 'Updated title'
);
```

### Delete a Link

```php
$client->links()->delete(123);
```

### List Links

```php
$linksResponse = $client->links()->list();

foreach ($linksResponse->links as $link) {
    echo $link->shortUrl . PHP_EOL;
}
```

### Pagination

```php
$links = $client->links()->list(
    limit: 100,
    fromId: 500
);
```

## Groups

### Create a Group

```php
$group = $client->groups()->create(
    name: 'Marketing'
);

echo $group->name;
```

### Create a Rotating Group

```php
$group = $client->groups()->create(
    name: 'Landing Pages',
    isRotate: true
);
```

### Get a Group

```php
$group = $client->groups()->get(10);
```

### Update a Group

```php
$group = $client->groups()->update(
    groupId: 10,
    description: 'Updated description'
);
```

### Delete a Group

```php
$client->groups()->delete(10);
```

### List Groups

```php
$response = $client->groups()->list(limit: 10, fromId: 1000);

foreach ($response->groups as $group) {
    echo $group->name . PHP_EOL;
}
```

## Error Handling

```php
use Lix\Exceptions\UnauthorizedException;
use Lix\Exceptions\ValidationException;

try {
    $client->links()->create(
        url: 'invalid-url'
    );
} catch (ValidationException $e) {
    // Validation failed
    
    // Validation error fields data
    var_dump($e->data);
} catch (UnauthorizedException $e) {
    // Invalid API key
}
```

## Documentation

* API Documentation: https://lix.li/api
* OpenAPI Specification: https://github.com/lix-url/openapi

## Other SDKs

- Go SDK: https://github.com/lix-url/go-sdk
- JavaScript SDK: https://github.com/lix-url/js-sdk
- Python SDK: https://github.com/lix-url/python-sdk


## Support

Need help with the API or SDK?

- Support Center: https://lix.li/support

## License

MIT
