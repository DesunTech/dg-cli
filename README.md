# A Simple CLI to Create and Manage GitHub Repositories and Collaborators

## Features
    Create a GitHub repository with a single command.
    Add multiple collaborators to a repository at once.
    Remove collaborators from a repository (single or multiple).
    Search repositories by name (case-insensitive, supports special characters).

## Installation
    Make sure you have php and composer installed in your system
    Add create a .env file with the following info

```sh
GITHUB_API_BASE_URL=https://api.github.com
GITHUB_ACCESS_TOKEN=
```

Next

```sh
composer install
```

## Usage

```sh
php dg.php --set-access-token                                      Set the GitHub access token
php dg.php --cr <repo-name> --d <description> --p <true/false>     Create a new repository (Optional: --d for description, --p for private/public)
php dg.php --ac <repo-name> <username>                             Add a single collaborator to a repository
php dg.php --ac <repo-name> <username1,username2,...>              Add multiple collaborators to a repository
php dg.php --rc <repo-name> <username>                             Remove a single collaborator from a repository
php dg.php --rc <repo-name> <username1,username2,...>              Remove multiple collaborators from a repository
php dg.php --s <search-query>                                      Search repositories by name (case-insensitive, supports special characters)
php dg.php --help                                                  Show this help message
```