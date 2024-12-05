<?php

return function ($args) {
    require __DIR__ . '/../config/config.php';

    $repoName = $args[1] ?? null;
    $usernames = $args[2] ?? null;

    if (!$repoName && !$usernames) {
        echo "Error: Repository name and username are required.\n";
        return;
    }
    if (!$repoName) {
        echo "Error: Repository name is required.\n";
        return;
    }
    if (!$usernames) {
        echo "Error: Username name is required.\n";
        return;
    }

    $usernamesArray = explode(',', $usernames);
    $githubUsername = getGitHubUsername($_ENV['GITHUB_ACCESS_TOKEN']);

    if (!$githubUsername) {
        echo "Error: Unable to fetch the GitHub username associated with the access token.\n";
        return;
    }
    $successMessage = '';
    $errorMessage = '';

    foreach ($usernamesArray as $username) {
        $username = trim($username);

        $url = $_ENV['GITHUB_API_BASE_URL'] . "/repos/$githubUsername/$repoName/collaborators/$username";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: token " . $_ENV['GITHUB_ACCESS_TOKEN'],
            'User-Agent: PHP-Script',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201 || $httpCode === 204) {
            $successMessage .= "Collaborator '$username' added to repository '$repoName'!\n";
        } else {
            $errorMessage .= "Error adding collaborator '$username': $response\n";
        }
    }

    if ($successMessage) {
        echo $successMessage;
    }

    if ($errorMessage) {
        echo $errorMessage;
    }
};
