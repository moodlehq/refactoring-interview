<?php

require_once 'lib.php';

$help = "Allows you to manage courses within the school.

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
\$ php courses.php -c 'Mathematics'";
