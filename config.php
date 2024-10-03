<?php
return [
    'ROLE_TEACHER' => 'Teacher',
    'ROLE_LEARNER' => 'Learner',
    'USER_HELP_TEXT' => "Allows you to manage users within the school.

    Options:
    -a, --all           Print out all user information
    -l, --learners      Print out only the learners information
    -t, --teacher       Print out only the teachers information
    -c, --create        Create a new user when given a name
    -u, --update        Update a user when given a user ID
    -d, --delete        Delete a user when given a user ID
    -h, --help          Print out this help
    
    Example:
    \$ php users.php -h
    \$ php users.php -a
    \$ php users.php -c -n 'John Doe' -e 'john@gmail.com' -r 'Teacher'
    \$ php users.php -u 1 -n 'Jean Doe' 
    \$ php users.php -d 1 ",
    'COURSE_HELP_TEXT' => "Allows you to manage courses within the school.

Options:
-a, --all               Print out all of the classes and its' participants
-p, --participants      Print out all participants within a given course when given an ID
-t, --teachers          Print out only the teachers information
-c, --create            Create a new course when given a name
-u, --update            Update a course when given a course ID
-d, --delete            Delete a course when given a course ID
-e, --enroll            Enroll a user into a course when given a user ID and course ID
-ue, --unenroll         Un-enroll a user from a course when given a user ID and course ID
-h, --help              Print out this help

Example:
\$ php courses.php -h
\$ php courses.php -a
\$ php courses.php -c -n 'Mathematics' -l 'Cambridge'
\$ php courses.php -u 1 -n 'Machine Learning' 
\$ php courses.php -d 1 
\$ php courses.php -p 1
\$ php courses.php -t",

];