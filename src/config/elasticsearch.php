<?php

return [
    'hosts' => ['localhost:9200'],
    'logging' => false,
    'logPath' => storage_path('logs/elastic-search.log'),
    'logLevel' => Psr\Log\LogLevel::WARNING,
];
