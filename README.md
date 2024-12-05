# A simple cli to create and manage github repo and colab

## Features
    - Create an github repo with a single command
    - Add multiple user as colab at once

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
php dg.php --cr <repo-name>                                 Create a new repository
php dg.php --ac <repo-name> <username>                      Add single collaborator to a repository
php dg.php --ac <repo-name> <username1, username2, ..>      Add multiple collaborator to a repository
php dg.php --help                                           Show this help message
php dg.php --set-access-token                               Set the access token
```