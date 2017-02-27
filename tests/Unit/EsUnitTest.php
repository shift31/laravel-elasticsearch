<?php
namespace Shift31\LaravelElasticsearch\Tests\Unit;

use Mockery;
use ReflectionClass;
use Shift31\LaravelElasticsearch\Facades\Es;
use Shift31\LaravelElasticsearch\Tests\TestCase;
use Shift31\LaravelElasticsearch\ElasticsearchServiceProvider;

class EsUnitTest extends TestCase
{
    public function test_to_facade_accessor_matches_service_provider()
    {
        $class = new ReflectionClass(new Es());
        $method = $class->getMethod('getFacadeAccessor');
        $method->setAccessible(true);
        $provider = new ElasticsearchServiceProvider(Mockery::mock('Illuminate\Foundation\Application'));
        $this->assertEquals($provider->provides(), (array)$method->invoke(new Es()));
    }
}