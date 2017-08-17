<?php

namespace Shift31\LaravelElasticsearch;

use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    const VERSION = '4.5.0';

    /** @var string */
    public $config_path;

    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->config_path = __DIR__ . '/../../config/elasticsearch.php';
        $this->publishes([
            $this->config_path => config_path('elasticsearch.php'),
            'elasticsearch',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->mergeConfigFrom($this->config_path, 'elasticsearch');
        $this->app->singleton('elasticsearch', function () {
            return ClientBuilder::fromConfig(config('elasticsearch'));
        });

        AliasLoader::getInstance()->alias('Es', 'Shift31\LaravelElasticsearch\Facades\Es');
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['elasticsearch'];
    }
}
