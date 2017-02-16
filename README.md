Elasticsearch for Laravel
=========================
[![Latest Stable Version](https://poser.pugx.org/shift31/laravel-elasticsearch/v/stable)](https://packagist.org/packages/shift31/laravel-elasticsearch)
[![Total Downloads](https://poser.pugx.org/shift31/laravel-elasticsearch/downloads)](https://packagist.org/packages/shift31/laravel-elasticsearch)
[![Build Status](https://travis-ci.org/shift31/laravel-elasticsearch.svg?branch=master)](https://travis-ci.org/shift31/laravel-elasticsearch)
[![Coverage Status](https://coveralls.io/repos/github/shift31/laravel-elasticsearch/badge.svg?branch=master)](https://coveralls.io/github/shift31/laravel-elasticsearch?branch=master)
[![License](https://poser.pugx.org/shift31/laravel-elasticsearch/license)](https://packagist.org/packages/shift31/laravel-elasticsearch)

This is a Laravel (4+) Service Provider for the official Elasticsearch low-level client:
http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/index.html


Version Matrix
------------------
Since there are breaking changes in Elasticsearch 1.0, your version of Elasticsearch must match the version of this 
library, which matches the version of the Elasticsearch low-level client. If you are using a version older than 1.0, you
 must install the `0.4` laravel-elasticsearch branch.  Otherwise, use the `1.0` branch.

The master branch will always track the latest version.

Old  
---
| Elasticsearch Version | laravel-elasticsearch branch |
| --------------------- | ---------------------------- |
| >= 1.0                | 1.0, 2.0                     |
| <= 0.90.*             | 0.4                          |

Attention: Until we launch new versions please keep using old versions and don't use dev-master branch!

New (Under development!)
------------------
| Elasticsearch Version | Laravel | laravel-elasticsearch branch |
| --------------------- |---------| ---------------------------- |
|  5.0                  | 4.2     | 4.5                          |
|  2.0                  | 4.2     | 4.2                          |
|  1.0                  | 4.2     | 4.1                          |
| <= 0.90.*             | 4.2     | 4.0                          |
|  5.0                  | 5.x     | 5.5                          |
|  2.0                  | 5.2     | 5.2                          |
|  1.0                  | 5.2     | 5.1                          |
| <= 0.90.*             | 5.2     | 5.0                          |

Usage
-----
1. Run `composer require shift31/laravel-elasticsearch:~4.0.0`

2. Publish config file

Laravel artisan command 
```
$ php artisan config:publish shift31/laravel-elasticsearch 
```

Manually: Create [app/config/elasticsearch.php](src/config/elasticsearch.php), modifying the following contents 
accordingly:
```php
<?php

return array(
    'hosts' => array(
                    'your.elasticsearch.server:9200'
                    ),
    'logPath' => 'path/to/your/elasticsearch/log',
);
```
Note: The keys of this array should be named according the parameters supported by Elasticsearch\Client.

3. In the `'providers'` array in app/config/app.php, add `'Shift31\LaravelElasticsearch\ElasticsearchServiceProvider'`. 

4. Use the `Es` facade to access any method from the `Elasticsearch\Client` class, for example:
```php
$searchParams['index'] = 'your_index';
$searchParams['size'] = 50;
$searchParams['body']['query']['query_string']['query'] = 'foofield:barstring';
$result = Es::search($searchParams);
```

Default Configuration
---------------------
If you return an empty array in the config file:

`'hosts'` defaults to localhost:9200

`'logPath'` defaults to `storage_path() . '/logs/elasticsearch.log'`

[Default config file](src/config/elasticsearch.php) which is publishing by artisan command.

Contributing
---------------------
Please see [CONTRIBUTING.md](CONTRIBUTING.md).