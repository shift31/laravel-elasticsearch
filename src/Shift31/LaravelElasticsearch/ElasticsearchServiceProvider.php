<?php namespace Shift31\LaravelElasticsearch;

use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class ElasticsearchServiceProvider
 *
 * ServiceProvider compatible with Laravel 5
 *
 * @package Shift31\LaravelElasticsearch
 */
class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // publish config file
        $this->publishes([
            __DIR__ . '/../../config/elasticsearch.php' => config_path('elasticsearch.php')
        ], 'config');

        // merge default config variables
        $this->mergeConfigFrom(__DIR__ . '/../../config/elasticsearch.php', 'elasticsearch');

        $this->app->singleton('Elasticsearch\Client', function () {
            $config = $this->app->config->get('elasticsearch');
            $logger = ClientBuilder::defaultLogger($config['logPath']);

            return ClientBuilder::crecdate()->setHosts($config['hosts'])->setLogger($logger)->build();

        });

        $this->app->alias('Elasticsearch\Client', 'elasticsearch');

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Es', 'Shift31\LaravelElasticsearch\Facades\Es');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['elasticsearch', 'Elasticsearch\Client'];
    }
}
