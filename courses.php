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

$courses = getSchoolClassInformation(null);
$courses = readcourseinfo($courses);

print_r($courses);

function createCourse() {
    //return createCourse();
}

function readcourseinfo($courses) {
    if (array_key_exists('isclassrominfo', $courses) and ($courses['isclassrominfo'] == 'true' || $courses['isclassrominfo'] == true || $courses['isclassrominfo'] == 1)) {
        unset($courses['isclassrominfo']);
        $courses = $courses['classes'];
    }
    return $courses;
}

function updateCourse() {
    //return updateCourse();
}

function deleteCourse() {
    //return deleteCourse();
}

function enrollmentManager($enroll = true) {
    if ($enroll) {
        // return enrollUser();
    } else {
        // return unenrollUser();
    }
}

function courseCRUD($action = 'R') {
    if ($action == 'C') {
        return createCourse();
    } else if ($action == 'R') {
        return readcourseinfo(getSchoolClassInformation(null));
    } else if ($action == 'U') {
        return updateCourse();
    } else if ($action == 'D') {
        return deleteCourse();
    }
}
