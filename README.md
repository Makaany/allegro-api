# PHP Allegro API

A simple Allegro API client library, written with PHP5.

## Requirements
* PHP >= 5.5
* A HTTP client

## Features
* REST and SOAP WebApi
* Sandbox support
* Auto-complete
* PSR compatible

## Installation

Via Composer:

```bash
composer require ircykk/allegro-api
```

Library is build on top of [HTTPlug](http://httplug.io/), we need to install HTTP client.

```bash
composer require php-http/guzzle6-adapter
```

## Developer Documentation
https://developer.allegro.pl/documentation/

## Usage of client

### Authentication with OAuth

```php
<?php

// Composer autoload
require_once __DIR__.'/vendor/autoload.php';

$credentials = ...

$client = new \Ircykk\AllegroApi\Client($credentials);

// Redirect to allegro for authenticate and get back with code
if (!isset($_GET['code'])) {
    header('Location: '.$client->getAuthUrl());
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Store access token...
}
```

We have `$token->access_token` for authenticate all our future requests.

See [example](examples/authentication.php).

### Making Requests

```php
<?php

// Composer autoload
require_once __DIR__.'/vendor/autoload.php';

$credentials = ...
$token = ...

$client = new \Ircykk\AllegroApi\Client($credentials);
$client->authenticate($token);

$categories = $client->sale()->categories()->all();
```

### Making SOAP Requests

```php
$credentials = ...

// WebApi SOAP client
$soapClient = new \Ircykk\AllegroApi\WebapiClient($credentials);

$categories = $soapClient->webApi()->getCatsDataLimit(0, 10);
```

### Sandbox

In order to use [Sandbox environment](https://allegro.pl.allegrosandbox.pl/) just set `Credentials` property `$sandbox` to true.
```php
$credentials = new \Ircykk\AllegroApi\Credentials(
    ...
    true // Sandbox
);
```

### Cache usage
Use any PSR-6 compatible library to cache requests.

In this example we use Symfony Cache, to install just run:
```bash
$ composer require symfony/cache
```

```php
$credentials = ...
$client = new Client($credentials);

$cache = new FilesystemAdapter();
$client->addCache($cache, ['default_ttl' => 3600]);
```
See [example](examples/cache.php).

### Logger
Use any PSR-3 logger library for example Monolog, to install just run:
```bash
$ composer require monolog/monolog
```

```php
$credentials = ...
$client = new Client($credentials);

$logger = new Logger('api');
$logger->pushHandler(
    new StreamHandler(__DIR__.'/api.log', Logger::DEBUG)
);
$loggerPlugin = new LoggerPlugin($logger);
$client->addPlugin($loggerPlugin);
```
See [example](examples/log.php).

### Customization
Thanks to HTTPlug library can be customized easily, for example to set language use [HeaderDefaultsPlugin](http://docs.php-http.org/en/latest/plugins/headers.html) plugin:
```php
...
$headerDefaultsPlugin = new HeaderDefaultsPlugin([
    'Accept-Language' => 'en-US'
]);
$client->addPlugin($headerDefaultsPlugin);
```
See [full list](http://docs.php-http.org/en/latest/plugins/index.html) of available HTTPlug plugins.

## TO-DO
* Tests
* Documentation

## Contributing
Feel free to contribute.

## Credits
API client build on top of [HTTPlug](http://httplug.io/) and inspired by [KnpLabs](https://github.com/KnpLabs/) GitHub client.

Soap types generated by [wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) library.