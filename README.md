[![Latest Version on Packagist](https://img.shields.io/packagist/v/jalallinux/php-json-rpc-client.svg?style=flat-square)](https://packagist.org/packages/jalallinux/php-json-rpc-client)
[![Tests](https://github.com/jalallinux/php-json-rpc-client/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/jalallinux/php-json-rpc-client/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/jalallinux/php-json-rpc-client.svg?style=flat-square)](https://packagist.org/packages/jalallinux/php-json-rpc-client)

This Package helps developers to easily connect to RPC servers.

## Installation

You can install the package via composer:

```bash
composer require jalallinux/php-json-rpc-client
```

## Usage

### Create instance:
Supported options: https://docs.guzzlephp.org/en/stable/request-options.html#auth
```php
$rpc = new RpcClient('http://localhost:8000/rpc/server', '2.0');
```

### Defaults
- #### rpc version: `2.0`
- #### options:
```json
{
    "http_errors": false,
    "headers": {
      "Content-Type": "application/json",
      "Accept": "application/json"
    }
}
```

### Set options:
```php
$rpc->setOption('connect_timeout', 3.14);
```

### Set headers:
```php
$rpc->withHeaders(['api-key' => 'php-json-rpc-client-api-key']);
```

### Set BasicAuth credential:
```php
$rpc->withBasicAuth(['username', 'password']);
```

### Set JWT authorization token:
```php
$rpc->withJwtAuth('Bearer php-json-rpc-client-jwt-token');
```

### Add RPC request:
```php
$rpc->request('user.get', ['username' => 'jalallinux']);
$rpc->request('user.get', ['username' => 'jalallinux'], '1');
```

### Add RPC notification:
Description: https://www.jsonrpc.org/specification#notification
```php
$rpc->notify('user.get', ['username' => 'jalallinux']);
```

### Send final requests:
```php
$rpc->send();
```

### Full Example:
```php
$rpc = new RpcClient('http://localhost:8000/rpc/server', '2.0');

$response = $rpc->setOption('connect_timeout', 3.14);
                ->withHeaders(['api-key' => 'php-json-rpc-client-api-key']);
                ->withBasicAuth(['username', 'password']);
                ->withJwtAuth('Bearer php-json-rpc-client-jwt-token');
                ->request('user.get', ['username' => 'jalallinux']);
                ->request('user.get', ['username' => 'jalallinux'], '1');
                ->notify('user.get', ['username' => 'jalallinux']);
                ->send();
```

### Response Methods:
```php
$response->body(): string
$response->array(): array
$response->object(): object
$response->status(): int
$response->successful(): bool
$response->ok(): bool
$response->failed(): bool
$response->clientError(): bool
$response->serverError(): bool
$response->header(string $header): string
$response->headers(): array
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [JalalLinuX](https://github.com/jalallinux)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
