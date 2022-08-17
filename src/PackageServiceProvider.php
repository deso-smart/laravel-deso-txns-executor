<?php

namespace DesoSmart\DesoTxnsExecutor;

use Illuminate\Support\ServiceProvider;

final class PackageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getPackageConfigPath() => $this->app->configPath('deso_txns_executor.php'),
            ], 'config');
        }
    }

    private function getPackageConfigPath(): string
    {
        return dirname(__DIR__).'/config/deso_txns_executor.php';
    }

    public function register(): void
    {
        $this->mergeConfigFrom($this->getPackageConfigPath(), 'deso_txns_executor');

        $this->app->singleton(DesoTxnsExecutor::class, function ($app) {
            return new DesoTxnsExecutor(
                baseUri: $app->config->get('deso_txns_executor.base_uri'),
                vendorKey: $app->config->get('deso_txns_executor.vendor_key'),
            );
        });
    }
}
