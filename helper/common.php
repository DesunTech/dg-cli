<?php

/** 
 * Function to get the GitHub username using the access token
 * 
 * @param string $accessToken
 * @return string|null
 */
function getGitHubUsername(string $accessToken): string|null
{
    $url = 'https://api.github.com/user';

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

/**
 * Make github request with curl
 * 
 * @param string $method
 * @param string $endpoint
 * @param string $token
 * @param array|null $data
 * 
 * @return array
 */
function makeGitHubRequest(string $method, string $endpoint, string $token, array|null $data = null): array|null
{
    $url = 'https://api.github.com/' . $endpoint;

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        'User-Agent: PHP-Script',
        'Content-Type: application/json',
    ]);

    // Set request method
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

    // Set POST fields if data is provided
    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Decode JSON response
    $response = json_decode($response, true);

    return [
        'httpCode' => $httpCode,
        'response' => $response,
    ];
}

/**
 * Function to get count of repo from api
 * 
 * @param string $username
 * @param string $token
 * @return int
 */
function getRepoCountFromAPI(string $username, string $token): int
{
    $endpoint = "search/repositories?q=user:$username&per_page=1";
    $result = makeGitHubRequest('GET', $endpoint, $token);
    return $result['response']['total_count'] ?? 0;
}
