<?php
namespace Shift31\LaravelElasticsearch\Tests\Unit;

use Mockery;
use Elasticsearch\Client;
use Mockery\MockInterface;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Shift31\LaravelElasticsearch\Tests\TestCase;
use Shift31\LaravelElasticsearch\ElasticsearchServiceProvider;

class ElasticsearchServiceProviderUnitTest extends TestCase
{
    public function test_it_should_provide_elasticsearch()
    {
        $provider = new ElasticsearchServiceProvider(Mockery::mock(Application::class));
        $this->assertEquals(['elasticsearch'], $provider->provides());
    }

    public function test_boot_method_to_set_config_file()
    {
        $configPath = realpath($this->getSourcePath('config'));
        $filesMock = Mockery::mock(Filesystem::class, function (MockInterface $m) use ($configPath) {
            $m->shouldReceive('isDirectory')->with($configPath)->once()->andReturn(true);
            $m->shouldReceive('isDirectory')->withAnyArgs()->times(3)->andReturn(false);
        });
        $configMock = Mockery::mock(Repository::class, function (MockInterface $m) use ($configPath) {
            $m->shouldReceive('package')
                ->with('shift31/laravel-elasticsearch', $configPath, 'laravel-elasticsearch')
                ->once()
                ->andReturnSelf();
        });
        $application = Mockery::mock(Application::class, function (MockInterface $m) use ($configMock, $filesMock) {
            $m->shouldReceive('offsetGet')->with('config')->once()->andReturn($configMock);
            $m->shouldReceive('offsetGet')->with('files')->times(4)->andReturn($filesMock);
            $m->shouldReceive('offsetGet')->with('path')->once()->andReturn($this->getSourcePath());
        });
        $provider = new ElasticsearchServiceProvider($application);
        $this->assertNull($provider->boot());
    }

    public function test_register_method_to_set_singleton_elastic_search_client()
    {
        $configPath = $this->getSourcePath('config/elasticsearch.php');
        $configMock = Mockery::mock(Repository::class, function (MockInterface $m) {
            $m->shouldReceive('get')->with('elasticsearch')->andReturn([]);
        });
        $filesMock = Mockery::mock(Filesystem::class, function (MockInterface $m) use ($configPath) {
            $m->shouldReceive('getRequire')
                ->with($configPath)
                ->once()->andReturn([]);
        });
        $application = Mockery::mock(Application::class, function (MockInterface $m) use ($configMock, $filesMock) {
            $m->shouldReceive('booting')->once()->andReturnSelf();
            $m->shouldReceive('offsetGet')->with('config')->andReturn($configMock);
            $m->shouldReceive('offsetGet')->with('files')->andReturn($filesMock);
            $m->shouldReceive('singleton')->with('elasticsearch',
                Mockery::on(function ($closure) {
                    $this->assertInstanceOf(Client::class, $closure());

                    return true;
                }))->once()->andReturnSelf();
        });
        $provider = new ElasticsearchServiceProvider($application);
        $this->assertNull($provider->register());
    }

    public function test_register_method_to_set_elastic_search_facade()
    {
        $application = Mockery::mock(Application::class, function (MockInterface $m) {
            $m->shouldReceive('singleton')->once()->andReturnSelf();
            $m->shouldReceive('booting')->with(Mockery::on(function ($closure) {
                $closure();
                $loader = AliasLoader::getInstance();
                $this->assertArrayHasKey('Es', $loader->getAliases());
                $this->assertEquals('Shift31\LaravelElasticsearch\Facades\Es', $loader->getAliases()['Es']);

                return true;
            }))->andReturnSelf();
        });
        $provider = new ElasticsearchServiceProvider($application);
        $this->assertNull($provider->register());
    }

    protected function getSourcePath($path = '')
    {
        return realpath(__DIR__ . '/../../src/' . $path);
    }
}
