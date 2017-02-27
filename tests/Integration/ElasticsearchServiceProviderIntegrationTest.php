<?php
namespace Shift31\LaravelElasticsearch\Tests\Integration;

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

    public function test_get_elasticsearch_config()
    {
        $config = Config::get('shift31::elasticsearch');
        $this->assertArrayHasKey('hosts', $config);
        $this->assertArrayHasKey('logPath', $config);
        $this->assertArrayHasKey('logLevel', $config);
    }

    protected function getPackageProviders()
    {
        return ['Shift31\LaravelElasticsearch\ElasticsearchServiceProvider'];
    }
}
