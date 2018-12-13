# APNs (.p8) notifications channel for Laravel 5.3+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/semyonchetvertnyh/laravel-apn-notification-channel.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/apn-p8)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/semyonchetvertnyh/laravel-apn-notification-channel/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/apn-p8)
[![StyleCI](https://styleci.io/repos/161703866/shield)](https://styleci.io/repos/161703866)
[![Quality Score](https://img.shields.io/scrutinizer/g/semyonchetvertnyh/laravel-apn-notification-channel.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/apn-p8)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/semyonchetvertnyh/laravel-apn-notification-channel/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/apn-p8/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/semyonchetvertnyh/laravel-apn-notification-channel.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/apn-p8)

This package makes it easy to send notifications using Apple Push (APN) with Laravel 5.3+.

## Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
	- [Setting up the APN service](#setting-up-the-apn-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Features

- [X] Uses new Apple APNs HTTP/2 connection
- [X] Supports JWT-based authentication
- [X] Supports new iOS 10 features such as Collapse IDs, Subtitles and Mutable Notifications
- [X] Uses concurrent requests to APNs
- [X] Tested and working in APNs production environment
- [ ] Supports Certificate-based authentication

## Requirements

* PHP >= 7.0
* lib-curl >= 7.46.0 (with http/2 support enabled)
* lib-openssl >= 1.0.2e 

## Installation

Install this package with Composer:

```bash
composer require laravel-notification-channels/apn-p8
```

If you're installing the package in Laravel 5.4 or lower, you must import the service provider:

```php
// config/app.php
'providers' => [
    // ...
    SemyonChetvertnyh\NotificationChannelApn\ApnServiceProvider::class,
],
```

### Setting up the APN service

Add the credentials to your `config/broadcasting.php`:

```php
// config/broadcasting.php
'connections' => [
    ...
    'apn' => [
        'is_production' => env('APP_ENV') === 'production',
        'key_id' => env('APN_KEY_ID'),
        'team_id' => env('APN_TEAM_ID'),
        'app_bundle_id' => env('APN_APP_BUNDLE_ID'),
        'private_key_path' => env('APN_PRIVATE_KEY_PATH', storage_path('private_key.p8')),
        'private_key_secret' => env('APN_PRIVATE_KEY_SECRET'),
    ],
    ...
],
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use SemyonChetvertnyh\NotificationChannelApn\ApnChannel;
use SemyonChetvertnyh\NotificationChannelApn\ApnMessage;

class AccountApproved extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ApnChannel::class];
    }

    /**
     * Get the APN representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return ApnMessage
     */
    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Account approved')
            ->body("Your {$notifiable->service} account was approved!");
    }
}
```

In your `notifiable` model, make sure to include a `routeNotificationForApn()` method, which return one or an array of device tokens.

```php
/**
 * Route notifications for the APN channel.
 *
 * @return string|array
 */
public function routeNotificationForApn()
{
    return $this->apn_token;
}
```

### Available Message methods

 - `title($str)`
 - `subtitle($str)`
 - `body($str)`
 - `badge($int)`
 - `sound($str)`
 - `category($str)`
 - `custom($key, $value)`
 - `setCustom($array)`
 - `titleLocKey($str)`
 - `titleLocArgs($array)`
 - `actionLocKey($str)`
 - `setLocKey($str)`
 - `setLocArgs($array)`
 - `launchImage($str)`
 - `contentAvailability($bool)`
 - `mutableContent($bool)`
 - `threadId($str)`

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email semyon.chetvertnyh@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Semyon Chetvertnyh](https://github.com/semyonchetvertnyh)
- [Arthur Edamov](https://github.com/edamov)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
