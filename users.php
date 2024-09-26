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


$allusers = getlearnersintheSchool(null, false);

if (array_key_exists('isAUserTHING', $allusers)) {
    $allusers = $allusers['users'];
}

$users = readUsers($allusers);

print_r($users);
function readUsers($allusers) {
    $classinfo = getSchoolClassInformation(null);
    $newuserinfo = [];
    foreach ($allusers as $key => $user) {
        $user['courseinfo'] = [];
        foreach ($user['classes'] as $key => $class) {
            foreach ($classinfo['classes'] as $key => $value) {
                if ($value['id'] == $class['id']) {
                    array_push($user['courseinfo'], $value['name']. ': '. $value['location']);
                }
            }
        }
        unset($user['classes']);
        array_push($newuserinfo, $user);
    }
    return $newuserinfo;
}

//print_r($allusers);

function userCRUD($action = 'R') {
    if ($action == 'C') {
        //return createLearner();
    } else if ($action == 'R') {
        //return readLearner();
    } else if ($action == 'U') {
        //return updateLearner();
    } else if ($action == 'D') {
        //return deleteLearner();
    }
}
