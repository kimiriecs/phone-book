<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Logger\Log;

function app(): App
{
    return App::instance();
}

/**
 * @return Log
 */
function logger(): Log
{
    return app()->log();
}