Elasticsearch for Laravel 4
===========================
This is a Laravel 4 Service Provider for the offical Elasticsearch API client:
http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/index.html


Usage
-----
1. Require `"shift31/laravel-elasticsearch": "dev-master"` in your composer.json

2. Create app/config/elasticsearch.php, modifying the following contents accordingly:

        return array(
            'hosts' => array(
                            'your.elasticsearch.server:9200'
                        ),
            'logPath' => 'path/to/your/elasticsearch/log'
            'logLevel' => Logger::INFO;
        );

3. Add `'Shift31\LaravelElasticsearch\LaravelElasticsearchServiceProvider'` to your `'providers'` array in app/config/app.php

4. Use the `Es` facade to access any method from the `Elasticsearch\Client` class, for example:

        $searchParams['index'] = 'your_index';
        $searchParams['size'] = 50;
        $searchParams['body']['query']['query_string']['query'] = 'foofield:barstring';

        $result = Es::search($searchParams);


Default Configuration
---------------------
If you return an empty array in the config file:

`'hosts'` defaults to localhost:9200

`'logPath'` defaults to `storage_path() . '/logs/hostbase-elasticsearch-' . php_sapi_name() . '.log'`

`'logLevel'` defaults to `Logger::INFO`