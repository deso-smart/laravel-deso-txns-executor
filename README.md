# DeSo Txns Executor for Laravel

[![License](https://poser.pugx.org/deso-smart/laravel-deso-txns-executor/license)](https://packagist.org/packages/deso-smart/laravel-deso-txns-executor)
[![Latest Stable Version](https://poser.pugx.org/deso-smart/laravel-deso-txns-executor/v/stable)](https://packagist.org/packages/deso-smart/laravel-deso-txns-executor)
[![Total Downloads](https://poser.pugx.org/deso-smart/laravel-deso-txns-executor/downloads)](https://packagist.org/packages/deso-smart/laravel-deso-txns-executor)

## Installation

Require this package with composer.

```shell
composer require deso-smart/laravel-deso-txns-executor
```

Laravel >=5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="DesoSmart\DesoTxnsExecutor\PackageServiceProvider" --tag=config
```
