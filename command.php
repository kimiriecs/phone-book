<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\App;
use App\Core\Commands\Command;

############ Command line arguments
const COMMAND_NAME_ARGUMENT_POSITION = 1;

############ Run Command
$app = App::start(__DIR__);

$commandName = $argv[COMMAND_NAME_ARGUMENT_POSITION] ?? 'list';

/** @var Command $command */
$command = $app->make($commandName);
$command->run($argv);

exit();