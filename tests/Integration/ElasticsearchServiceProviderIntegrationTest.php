<?php
namespace Shift31\LaravelElasticsearch\Tests\Integration;

use Orchestra\Testbench\TestCase;
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

    protected function getPackageProviders()
    {
        return ['Shift31\LaravelElasticsearch\ElasticsearchServiceProvider'];
    }
}
