<?php

return function ($args) {
    require __DIR__ . '/../config/config.php';

    $repoName = $args[1] ?? null;
    if (!$repoName) {
        echo "Error: Repository name is required.\n";
        return;
    }

    $url = $_ENV['GITHUB_API_BASE_URL'] . '/user/repos';

    // Repository data
    $data = [
        'name' => $repoName,
        'description' => "Repository for $repoName",
        'private' => false, // Set to true for a private repository
    ];

    // Set up cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $_ENV['GITHUB_ACCESS_TOKEN'],
        'User-Agent: PHP-Script',
        'Content-Type: application/json',
    ]);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response = json_decode($response, true);
    // Handle the response
    if ($httpCode === 201) {
        $gitUrl = $response['clone_url'];
        echo "Repository created! URL: $gitUrl\n";
    } else {
        echo "Failed to create repository. Error: " . ($response['message'] ?? 'Unknown error') . "\n";
    }
};
