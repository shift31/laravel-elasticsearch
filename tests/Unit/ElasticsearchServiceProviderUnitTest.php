<?php

namespace Shift31\LaravelElasticsearch\Tests\Unit;

use Illuminate\Foundation\Application;
use Illuminate\Container\Container;
use Shift31\LaravelElasticsearch\ElasticsearchServiceProvider;

class ElasticsearchServiceProviderUnitTest extends \Orchestra\Testbench\TestCase
{
    /**
     * @var ElasticsearchServiceProvider
     */
    protected $provider;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Application
     */
    protected $application;

    public function setUp()
    {
        parent::setUp();
        $configPath = realpath($this->getSourcePath('config'));
        $this->container = $this->createMock(Container::class);
        $this->container->method('getInstance')->willReturn($this->container);
        $this->container->method('make')->with('path.config')->willReturn($configPath);
        Container::setInstance($this->container);
        $this->application = $this->createMock('Illuminate\Foundation\Application');
        $this->application->method('make')->with('path.config')->willReturn($configPath);
        $this->provider = new ElasticsearchServiceProvider($this->application);
    }

    public function test_it_should_provide_elasticsearch()
    {
        $this->assertEquals(['elasticsearch'], $this->provider->provides());
    }

    public function test_boot_method_to_set_config_file()
    {
        $this->assertNull($this->provider->boot());
    }


    protected function getSourcePath($path = '')
    {
        return realpath(__DIR__ . '/../../src/' . $path);
    }
}
