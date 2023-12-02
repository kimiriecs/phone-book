<?php declare(strict_types=1);

use App\Core\App;

return [
    'session_name' => App::env()->get('APP_NAME', 'project'),
    'use_cookie' => App::env()->getBoolean('SESSION_USE_COOKIE', true),
    'use_only_cookie' => App::env()->getBoolean('SESSION_USE_ONLY_COOKIE', true),
    'life_time' => App::env()->getInt('SESSION_LIFETIME', 120),
    'path' => App::env()->get('SESSION_PATH', '/'),
    'domain' => App::env()->get('SESSION_DOMAIN', '.site.com'),
    'secure' => App::env()->getBoolean('SESSION_SECURE', false),
    'http_only' => App::env()->getBoolean('SESSION_HTTP_ONLY', false),
    'same_site' => App::env()->get('SESSION_SAME_SITE', 'Lax'),
];
