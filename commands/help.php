<?php

return function () {
    echo "Available Commands:\n";
    echo "  php dg.php --cr <repo-name>                                 Create a new repository\n";
    echo "  php dg.php --ac <repo-name> <username>                      Add single collaborator to a repository\n";
    echo "  php dg.php --ac <repo-name> <username1, username2, ..>      Add multiple collaborator to a repository\n";
    echo "  php dg.php --help                                           Show this help message\n";
    echo "  php dg.php --set-access-token                               Set the access token\n";
};
