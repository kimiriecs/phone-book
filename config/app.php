<?php

declare(strict_types=1);

use App\Core\App;

$basePath = App::basePath();

return [
    'paths' => [
        'routes' => "$basePath/routes/",
        'views' => "$basePath/resources/views/",
        'logs' => "$basePath/logs/",
        'database' => "$basePath/database/",
        'migrations' => "$basePath/database/Migrations/",
        'seeders' => "$basePath/database/Seeders/",
        'commands' => "$basePath/app/Core/Commands/",
    ],

    'timezone' => 'Europe/Kiev'
];