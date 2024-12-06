<?php
// Function to get data from cache
function getCacheData(string $cacheFile): array
{
    if (file_exists($cacheFile)) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    return [];
}

return function ($args) {
    $username = getGitHubUsername($_ENV['GITHUB_ACCESS_TOKEN']);
    $token = $_ENV['GITHUB_ACCESS_TOKEN'];

    $searchQuery = $args[1] ?? null;

    $cacheFile = dirname(__DIR__) . '/repo_cache.json';
    $apiCount = getRepoCountFromAPI($username, $token);

    $repoNames = getCacheData($cacheFile);
    $cacheCount = count($repoNames);

    if (!file_exists($cacheFile) || $cacheCount !== $apiCount) {
        $endpoint = "search/repositories?q=user:$username&per_page=100";
        $repoNames = [];
        $page = 1;
        $hasMoreRepos = true;

        while ($hasMoreRepos) {
            $endpointWithPagination = $endpoint . "&page=$page";

            $result = makeGitHubRequest('GET', $endpointWithPagination, $token);

            if (isset($result['response']['items'])) {
                foreach ($result['response']['items'] as $repo) {
                    array_push($repoNames, [
                        'name' => $repo['name'],
                        'url'  => $repo['html_url']
                    ]);
                }
            }

            if (count($result['response']['items']) < 100) {
                $hasMoreRepos = false;
            }

            $page++;
        }

        file_put_contents($cacheFile, json_encode($repoNames, JSON_PRETTY_PRINT));
    }

    if (!empty($searchQuery)) {
        $query = preg_quote($searchQuery, '/'); // Escape special characters for regex

        $filteredRepos = array_filter($repoNames, function ($repo) use ($query) {
            return preg_match("/$query/i", $repo['name']); // Case-insensitive search
        });

        if (!empty($filteredRepos)) {
            echo "Search Results:\n";
            foreach ($filteredRepos as $repo) {
                $highlightedName = preg_replace(
                    "/($query)/i",
                    "\033[1;33m$1\033[0m", // Bold and yellow
                    $repo['name']
                );

                echo "- {$highlightedName} ({$repo['url']})\n";
            }
        } else {
            echo "No repositories found matching your query.\n";
        }
    } else {
        echo "No search query provided. Cache has been updated.\n";
    }
};
