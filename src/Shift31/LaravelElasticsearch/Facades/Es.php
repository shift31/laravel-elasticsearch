<?php


namespace Shift31\LaravelElasticsearch\Facades;


use Illuminate\Support\Facades\Facade;


class Es extends Facade {

    protected static function getFacadeAccessor() { return 'elasticsearch'; }
}