<?php

require_once 'lib.php';

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

$short_options = "a::l::t::c:u:d:h::n:e:";
$long_options = ["all:", "learners:", "teachers:", "create:", "update:", "delete:", "help:", "name:", "email:"];
$options = getopt($short_options, $long_options);

if (isset($options['h']) || isset($options['help'])) {
    echo $help;
    exit(0);
}

if (isset($options['a']) || isset($options['all'])) {
    echo 'All users:'.PHP_EOL;
    $users = getUserService()->getAllUsers();
    $users = array_map(function ($user) {
        return $user->formatForPrint();
    }, $users);
    print_r($users);
    exit(0);
}

if (isset($options['l']) || isset($options['learners'])) {
    echo 'Learners:'.PHP_EOL;
    $users = getUserService()->getAllStudents();
    $users = array_map(function ($user) {
        return $user->formatForPrint();
    }, $users);
    print_r($users);
    exit(0);
}

if (isset($options['t']) || isset($options['teachers'])) {
    echo 'Teachers:'.PHP_EOL;
    $users = getUserService()->getAllTeachers();
    $users = array_map(function ($user) {
        return $user->formatForPrint();
    }, $users);
    print_r($users);
    exit(0);
}

if (isset($options['c']) || isset($options['create'])) {
    $name = isset($options['c']) ? $options['c'] : $options['create'];
    $email = isset($options['e']) ? $options['e'] : $options['email'] ?? '';
    $user = getUserService()->addUser($name, $email);
    echo 'User created:'.PHP_EOL;
    print_r($user->formatForPrint());
    exit(0);
}

if (isset($options['u']) || isset($options['update'])) {
    $name = isset($options['u']) ? $options['u'] : $options['update'];
    $email = isset($options['e']) ? $options['e'] : $options['email'] ?? '';
    $user = getUserService()->updateUser($name, $email);
    echo 'User updated:'.PHP_EOL;
    print_r($user->formatForPrint());
    exit(0);
}

if (isset($options['d']) || isset($options['delete'])) {
    $name = isset($options['d']) ? $options['d'] : $options['delete'];
    $user = getUserService()->deleteUser($name);
    echo 'User deleted:'.PHP_EOL;
    print_r($user->formatForPrint());
    exit(0);
}
