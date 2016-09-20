<?php namespace Shift31\LaravelElasticsearch;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Elasticsearch\ClientBuilder;

/**
 * Class LaravelElasticsearchServiceProvider
 *
 * ServiceProvider compatible with Laravel 4
 *
 * @package Shift31\LaravelElasticsearch
 */
class LaravelElasticsearchServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('shift31/laravel-elasticsearch', null, __DIR__ . '/../..');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // set elasticsearch config
        $this->setConfig();
        $this->app->singleton('elasticsearch', function () {
            $config = $this->app->config->get('elasticsearch');
            $logger = ClientBuilder::defaultLogger($config['logPath']);

            return ClientBuilder::create()->setHosts($config['hosts'])->setLogger($logger)->build();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Es', 'Shift31\LaravelElasticsearch\Facades\Es');
        });
    }

    private function setConfig()
    {
        $packageConfigPath = __DIR__ . '/../../config/elasticsearch.php';
        $config = $this->app['config']->get('elasticsearch', []);
        $this->app['config']->set('elasticsearch', array_merge(require $packageConfigPath, $config));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('elasticsearch');
    }
}
