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
        $this->package('shift31/laravel-elasticsearch', 'shift31');
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton('elasticsearch', function () {
            $config = array_merge($this->loadDefaultConfig(), $this->app->config->get('shift31::elasticsearch'));

            return ClientBuilder::fromConfig($config);
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Es', 'Shift31\LaravelElasticsearch\Facades\Es');
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['elasticsearch'];
    }

    private function loadDefaultConfig()
    {
        return $this->app->files->getRequire(realpath(__DIR__ . '/../../config/elasticsearch.php'));
    }
}
