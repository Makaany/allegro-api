# PHP Allegro API

A simple Allegro API client library, written with PHP5.

## Requirements
* PHP >= 5.5
* A HTTP client

## Features
* REST and SOAP WebApi
* Sandbox Support
* Auto-complete

## Install

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
require_once __DIR__ . '/vendor/autoload.php';

// Allegro API credentials
$credentials = new \Ircykk\AllegroApi\Credentials(
    'xxx', // Client Id
    'yyy', // Client Secret
    'zzz' // App URL ex. "http://example.com/example.php"
);

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

### Making Requests

```php
<?php

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

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
    'xxx', // Sandbox Client Id
    'yyy', // Sandbox Client Secret
    'zzz', // App URL
    true // Sandbox
);
```

## TO-DO
* Tests
* Documentation
* Examples
* More detailed README

## Contributing
Feel free to post found issues and contribute.

## Credits
API client build on top of [HTTPlug](http://httplug.io/) and inspired by [KnpLabs](https://github.com/KnpLabs/) GitHub client.

Soap types generated by [wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) library.