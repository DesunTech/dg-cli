<?php

return function ($args) {
    $accessToken = $args[1] ?? null;

    if (!$accessToken) {
        echo "Please provide an access token.\n";
        return;
    }

    $data = [
        'token' => $accessToken
    ];

    file_put_contents(__DIR__ . '/access_token.json', json_encode($data, JSON_PRETTY_PRINT));

    echo 'Access token set successfully!';
};
