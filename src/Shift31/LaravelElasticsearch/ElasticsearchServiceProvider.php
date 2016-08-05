<?php namespace Shift31\LaravelElasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;


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

            // merge settings from app/config/elasticsearch.php
            $params = array_merge($connParams, $this->app['config']->get('elasticsearch', array()));

            $clientBuilder = new \Elasticsearch\ClientBuilder();
            $clientBuilder->setHosts($params['hosts']);

            // this is the new way of making the client!
            return $clientBuilder->create()->build();

        });



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