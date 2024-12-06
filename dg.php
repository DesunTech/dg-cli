#!/usr/bin/env php
<?php
if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.\n");
}

require __DIR__ . '/config/config.php';

$commands = [
    '--cr' => require __DIR__ . '/commands/createRepo.php',
    '--ac' => require __DIR__ . '/commands/addCollab.php',
    '--rc' => require __DIR__ . '/commands/removeCollab.php',
    '--s' => require __DIR__ . '/commands/searchRepo.php',
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

switch ($command) {
    case '--cr':
        $repoName = null;
        $description = null;
        $isPrivate = true;

        foreach ($args as $index => $arg) {
            switch ($arg) {
                case '--cr':
                    $repoName = $args[$index + 1] ?? null;
                    break;
                case '--d':
                    $description = $args[$index + 1] ?? null;
                    break;
                case '--p':
                    $isPrivate = isset($args[$index + 1]) ? filter_var($args[$index + 1], FILTER_VALIDATE_BOOLEAN) : false;
                    break;
            }
        }

        if (!$repoName) {
            echo "Error: Repository name is required.\n";
            exit(1);
        }

        $commands['--cr']([$repoName, $description, $isPrivate]);
        break;
    default:
        $commands[$command]($args);
        break;
}
