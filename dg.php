#!/usr/bin/env php
<?php
if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.\n");
}

$commands = [
    '--cr' => require __DIR__ . '/commands/createRepo.php',
    '--ac' => require __DIR__ . '/commands/addCollab.php',
    '--help' => require __DIR__ . '/commands/help.php',
    '--set-access-token' => require __DIR__ . '/commands/setAccessToken.php',
];

$args = $argv;
array_shift($args);

$command = $args[0] ?? '--help';
if (!isset($commands[$command])) {
    echo "Unknown command: $command\n";
    $commands['--help']();
    exit(1);
}

$commands[$command]($args);
