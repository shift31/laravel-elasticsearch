<?php

namespace Shift31\LaravelElasticsearch;

use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    const VERSION = '4.5.0';

    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/elasticsearch.php' => config_path('elasticsearch.php'),
            'elasticsearch',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/elasticsearch.php', 'elasticsearch');
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
