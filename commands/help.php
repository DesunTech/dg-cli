<?php

return function () {
    echo "Available Commands:\n";
    echo "  php dg.php --set-access-token                                       Set the access token\n";
    echo "  php dg.php --cr <repo-name> --d <description> --p <true/false>      Create a new repository (Optional: --d for description, --p for private/public)\n";
    echo "  php dg.php --ac <repo-name> <username>                              Add a single collaborator to a repository\n";
    echo "  php dg.php --ac <repo-name> <username1,username2,...>               Add multiple collaborators to a repository\n";
    echo "  php dg.php --rc <repo-name> <username>                              Remove a single collaborator from a repository\n";
    echo "  php dg.php --rc <repo-name> <username1,username2,...>               Remove multiple collaborators from a repository\n";
    echo "  php dg.php --s <search-query>                                       Search repositories by name (case-insensitive, supports special characters)\n";
    echo "  php dg.php --help                                                   Show this help message\n";
};
