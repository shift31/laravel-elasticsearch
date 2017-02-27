<?php
namespace Shift31\LaravelElasticsearch;

use Elasticsearch\Client;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    const VERSION = '4.0.0';

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
            $customConfig = $this->app->config->get('shift31::elasticsearch');
            $defaultConfig = $this->loadDefaultConfig();

            return new Client(array_merge($defaultConfig, $customConfig));
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
