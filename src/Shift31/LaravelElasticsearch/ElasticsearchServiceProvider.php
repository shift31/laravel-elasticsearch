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
        $this->app->singleton('Elasticsearch\Client', function () {

            $connParams = array();
            $connParams['hosts'] = ['localhost:9200'];
            $connParams['logPath'] = storage_path() . '/logs/elasticsearch-' . php_sapi_name() . '.log';

            // merge settings from app/config/elasticsearch.php
            $params = array_merge($connParams, $this->app['config']->get('elasticsearch', array()));

            $logger = ClientBuilder::defaultLogger($params['logPath']);

            return ClientBuilder::create()->setHosts($params['hosts'])->setLogger($logger)->build();

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
