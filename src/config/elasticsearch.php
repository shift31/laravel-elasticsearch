<?php

return [
    'hosts' => ['localhost:9200'],
    'logger' => Elasticsearch\ClientBuilder::defaultLogger(storage_path('logs/elastic-search.log'), 400),
    'retries' => 1,
];
