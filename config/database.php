<?php declare(strict_types=1);

use App\Core\Helpers\Env;

return [
    'default' => Env::get('DB_CONNECTION', 'mysql'),
    'connection' => [
        'mysql' => [
            'port' => Env::get('DB_PORT', 3306),
            'host' => Env::get('DB_HOST', 'localhost'),
            'database' => Env::get('DB_DATABASE', 'phone-book'),
            'user_name' => Env::get('DB_USERNAME', 'dev'),
            'password' => Env::get('DB_PASSWORD', 'dev'),
        ]
    ]
];
