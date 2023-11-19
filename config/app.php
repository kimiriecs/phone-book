<?php

declare(strict_types=1);

use App\Core\App;

return [
    'paths' => [
        'routes' => App::instance()->basePath() . '/routes/',
        'views' => App::instance()->basePath() . '/resources/views/',
        'logs' => App::instance()->basePath() . '/logs/',
    ],

    'timezone' => 'Europe/Kiev'
];