<?php declare(strict_types=1);

use App\Core\Helpers\Env;

return [
    'session_name' => Env::get('APP_NAME', 'project'),
    'use_cookie' => Env::getBoolean('SESSION_USE_COOKIE', true),
    'use_only_cookie' => Env::getBoolean('SESSION_USE_ONLY_COOKIE', true),
    'life_time' => Env::getInt('SESSION_LIFETIME', 120),
    'path' => Env::get('SESSION_PATH', '/'),
    'domain' => Env::get('SESSION_DOMAIN', '.site.com'),
    'secure' => Env::getBoolean('SESSION_SECURE', false),
    'http_only' => Env::getBoolean('SESSION_HTTP_ONLY', false),
    'same_site' => Env::get('SESSION_SAME_SITE', 'Lax'),
];
