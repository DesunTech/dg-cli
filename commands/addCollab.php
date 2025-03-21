<?php

return function ($args) {
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

        $endpoint = "repos/$githubUsername/$repoName/collaborators/$username";

        $result = makeGitHubRequest('PUT', $endpoint, $_ENV['GITHUB_ACCESS_TOKEN']);

        if ($result['httpCode'] === 201 || $result['httpCode'] === 204) {
            $successMessage .= "Collaborator '$username' added to repository '$repoName'!\n";
        } else {
            $errorMessage .= "Error adding collaborator '$username': " .
                $result['response']['message'] .
                (isset($result['response']['errors'][0]['message'])
                    ? ", " . $result['response']['errors'][0]['message']
                    : "") .
                "\n";
        }
    }

    if ($successMessage) {
        echo $successMessage;
    }

    if ($errorMessage) {
        echo $errorMessage;
    }
};
