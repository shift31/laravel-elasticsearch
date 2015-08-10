Elasticsearch for Laravel
=========================
This is a Laravel (4+) Service Provider for the official Elasticsearch low-level client:
http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/index.html


Version Matrix
--------------
Since there are breaking changes in Elasticsearch 1.0, your version of Elasticsearch must match the version of this library, which matches the version of the Elasticsearch low-level client.
If you are using a version older than 1.0, you must install the `0.4` laravel-elasticsearch branch.  Otherwise, use the `1.0` branch.

The master branch will always track the latest version.

| Elasticsearch Version | laravel-elasticsearch branch |
| --------------------- | ---------------------------- |
| >= 1.0                | 1.0                          |
| <= 0.90.*             | 0.4                          |

**Support for v1.1.x of the Elasticsearch client has been added in v1.1 of laravel-elasticsearch.**  We'll try to be consistent with this convention going forward.

Usage
-----
1. Run `composer require shift31/laravel-elasticsearch:~1.0`

2. Create app/config/elasticsearch.php, modifying the following contents accordingly:
```php
<?php

use Monolog\Logger;

return array(
    'hosts' => array(
                    'your.elasticsearch.server:9200'
                    ),
    'logPath' => 'path/to/your/elasticsearch/log',
    'logLevel' => Logger::INFO
);
```

The keys of this array should be named according the parameters supported by Elasticsearch\Client.

3. In the `'providers'` array in app/config/app.php, if you are using Laravel 4.x, add `'Shift31\LaravelElasticsearch\LaravelElasticsearchServiceProvider'`. 
 
 **If you are using Laravel 5.x**, add `'Shift31\LaravelElasticsearch\ElasticsearchServiceProvider'`. The ServiceProvider will enable the 'Es' facade for you.

4. Use the `Es` facade to access any method from the `Elasticsearch\Client` class, for example:
```php
$searchParams['index'] = 'your_index';
$searchParams['size'] = 50;
$searchParams['body']['query']['query_string']['query'] = 'foofield:barstring';

$result = Es::search($searchParams);
```

**A friendly reminder:**  If you use the facade in a namespaced class (i.e. in a Laravel 5.x controller), you must add `use Es;` at the top of your file (after `<?php` of course), or add a backslash in front of any static calls (ex: `\Es::search(...)`).

Default Configuration
---------------------
If you return an empty array in the config file:

`'hosts'` defaults to localhost:9200

`'logPath'` defaults to `storage_path() . '/logs/elasticsearch-' . php_sapi_name() . '.log'`

`'logLevel'` defaults to `Logger::INFO`
