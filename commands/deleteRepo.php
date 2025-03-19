<?php

return function ($args) {
    $repoName = $args[1] ?? null;
    $owner = $args[2] ?? null;

    if (!$repoName || !$owner) {
        echo "Error: Repository name and owner are required.\n";
        return;
    }

    // Endpoint for deleting the repository
    $endpoint = "repos/{$owner}/{$repoName}";

    // Make the request to GitHub API
    $result = makeGitHubRequest('DELETE', $endpoint, $_ENV['GITHUB_ACCESS_TOKEN']);

    if ($result['httpCode'] === 204) {
        echo "Repository '{$repoName}' deleted successfully.\n";
    } else {
        echo "Failed to delete repository. Error: " . ($result['response']['message'] ?? 'Unknown error') . "\n";
    }
};
