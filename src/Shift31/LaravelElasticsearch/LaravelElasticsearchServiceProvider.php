<?php namespace Shift31\LaravelElasticsearch;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Monolog\Logger;
use Config;
use Elasticsearch\Client;


class LaravelElasticsearchServiceProvider extends ServiceProvider {

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
		$this->package('shift31/laravel-elasticsearch');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('elasticsearch', function()
			{

				$connParams = array();
				$connParams['hosts'] = array('localhost:9200');
				$connParams['logPath'] = storage_path() . '/logs/hostbase-elasticsearch-' . php_sapi_name() . '.log';
				$connParams['logLevel'] = Logger::INFO;

				// merge settings from app/config/elasticsearch.php
				$params = array_merge($connParams, Config::get('elasticsearch'));

				return new Client($params);
			});

		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function()
			{
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
		return array('elasticsearch');
	}

}