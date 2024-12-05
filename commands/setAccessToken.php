<?php

return function ($args) {
    require __DIR__ . '/../config/config.php';

    $accessToken = $args[1] ?? null;

    if (!$accessToken) {
        echo "Please provide an access token.\n";
        return;
    }
};
