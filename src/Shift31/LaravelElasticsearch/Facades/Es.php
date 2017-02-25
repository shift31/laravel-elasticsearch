<?php namespace Shift31\LaravelElasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elasticsearch\Client
 */
class Es extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'elasticsearch';
    }
}
