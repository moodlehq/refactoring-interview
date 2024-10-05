<?php

require_once 'lib.php';

includeAutoLoad();

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

$short_options = "a::l::t::c:u:d:h::";
$long_options = ["all:", "learners:", "teachers:", "create:", "update:", "delete:", "help"];
$options = getopt($short_options, $long_options);

if (isset($options['h']) || isset($options['help'])) {
    echo $help;
    exit(0);
}

if (isset($options['a']) || isset($options['all'])) {
    echo 'All users:'.PHP_EOL;
    $users = getAllUsers();
    print_r($users);
    exit(0);
}

if (isset($options['l']) || isset($options['learners'])) {
    echo 'Learners:'.PHP_EOL;
    print_r(getStudentsInforamtion());
    exit(0);
}

if (isset($options['t']) || isset($options['teachers'])) {
    echo 'Teachers:'.PHP_EOL;
    print_r(getTeachersInforamtion());
    exit(0);
}

if (isset($options['c']) || isset($options['create'])) {

    $name = isset($options['c']) ? $options['c'] : $options['create'];
    // Get opts and pass it to the CRUD.
    $user = userCRUD('C');
    echo 'User created:'.PHP_EOL;
    print_r($user);
    exit(0);
}

if (isset($options['u']) || isset($options['update'])) {
    $id = isset($options['u']) ? $options['u'] : $options['update'];
    $user = userCRUD('U');
    echo 'User updated:'.PHP_EOL;
    print_r($user);
    exit(0);
}

if (isset($options['d']) || isset($options['delete'])) {
    $id = isset($options['d']) ? $options['d'] : $options['delete'];
    $user = userCRUD('D');
    echo 'User deleted:'.PHP_EOL;
    print_r($user);
    exit(0);
}