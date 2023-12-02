<?php declare(strict_types=1);

use App\Core\App;

return [
    'default' => App::env()->get('DB_CONNECTION', 'mysql'),
    'connection' => [
        'db' => [
            'driver' => App::env()->get('DB_DRIVER', 'mysql'),
            'port' => App::env()->get('DB_PORT', 3306),
            'host' => App::env()->get('DB_HOST', 'localhost'),
            'database' => App::env()->get('DB_DATABASE', 'phone-book'),
            'user_name' => App::env()->get('DB_USER', 'dev'),
            'password' => App::env()->get('DB_PASSWORD', 'dev'),
        ]
    ]
];
