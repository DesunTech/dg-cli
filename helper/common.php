<?php

// Function to get the GitHub username using the access token
function getGitHubUsername($accessToken)
{
    $url = $_ENV['GITHUB_API_BASE_URL'] . '/user';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $accessToken",
        "User-Agent: php-script",
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        echo "Error fetching GitHub username: $response\n";
        return null;
    }

    $userData = json_decode($response, true);
    return $userData['login'] ?? null;
}
