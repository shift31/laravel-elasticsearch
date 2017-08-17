<?php

namespace Shift31\LaravelElasticsearch\Tests\Integration;

use Elasticsearch\ClientBuilder;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use Shift31\LaravelElasticsearch\Facades\Es;

class ElasticsearchServiceProviderIntegrationTest extends TestCase
{
    public function test_elasticsearch_simple_create_request()
    {
        $indexParams['index'] = 'shift31';
        $result = Es::indices()->create($indexParams);
        $this->assertArrayHasKey('acknowledged', $result);
        $this->assertTrue($result['acknowledged']);
    }

    public function test_to_see_elasticsearch_log_file()
    {
        $logPath = storage_path('logs/elastic-search.log');
        $logger = ClientBuilder::defaultLogger($logPath, 100);
        Config::set('shift31::elasticsearch.logger', $logger);
        $indexParams['index'] = 'shift31';
        $result = Es::indices()->delete($indexParams);
        $this->assertArrayHasKey('acknowledged', $result);
        $this->assertTrue($result['acknowledged']);
        $this->assertTrue(file_exists($logPath));
    }

    public function test_get_elasticsearch_config()
    {
        $config = Config::get('elasticsearch');
        $this->assertArrayHasKey('hosts', $config);
        $this->assertArrayHasKey('logger', $config);
        $this->assertArrayHasKey('retries', $config);
    }

    protected function getPackageProviders($app)
    {
        return ['Shift31\LaravelElasticsearch\ElasticsearchServiceProvider'];
    }
}
