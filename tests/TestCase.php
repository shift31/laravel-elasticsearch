<?php
namespace Shift31\LaravelElasticsearch\Tests;

use Mockery;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        if (class_exists('Mockery')) {
            Mockery::close();
        }
    }
}
