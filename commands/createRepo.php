<?php

return function ($args) {
    list($repoName, $description, $isPrivate) = $args;

    if (!$repoName) {
        echo "Error: Repository name is required.\n";
        return;
    }

    $endpoint = 'user/repos';

    // Repository data
    $data = [
        'name' => $repoName,
        'description' => $description ?? "Repository for $repoName",
        'private' => $isPrivate
    ];

    $result = makeGitHubRequest('POST', $endpoint, $_ENV['GITHUB_ACCESS_TOKEN'], $data);

    if ($result['httpCode'] === 201) {
        echo "Repository created! URL: " . $result['response']['clone_url'] . "\n";
    } else {
        echo "Failed to create repository. Error: " . ($result['response']['message'] ?? 'Unknown error') . "\n";
    }
};
