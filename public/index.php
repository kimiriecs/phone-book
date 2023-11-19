<?php

require __DIR__ . '/../vendor/autoload.php';

$app = \App\Core\App::instance();

$app->run(dirname(__DIR__));