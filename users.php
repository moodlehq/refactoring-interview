<?php

require_once 'test.php';

$help = "Allows you to manage users within the school.

Options:
-a, --all           Print out all user information
-l, --learners      Print out only the learners information
-t, --teacher       Print out only the teachers information
-c, --create        Create a new user when given a name
-u, --update        Update a user when given a user ID
-d, --delete        Delete a user when given a user ID
-h, --help          Print out this help

Example:
\$ php users.php -u 1 -n 'John Doe'";

print_r(enrolledIntoclass());
