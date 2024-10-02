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
-e, --enroll            Enroll a user into a course when given a user name and course ID
-ue, --unenroll         Un-enroll a user from a course when given a user name and course ID
-h, --help              Print out this help

Example:
\$ php courses.php -c 'Mathematics'";

$short_options = "a::p:t:c:u:d:h::e:un:n:l:";
$long_options = ["all:", "participants:", "teachers:", "create:", "update:", "delete:", "enroll:", "unenroll:", "help:", "name:", "location:"];
$options = getopt($short_options, $long_options);

if (isset($options['h']) || isset($options['help'])) {
    echo $help;
    exit(0);
}

if (isset($options['a']) || isset($options['all'])) {
    echo 'All courses:'.PHP_EOL;
    $courses = getCourseService()->getAllCourses();
    $courses = array_map(function ($course) {
        return $course->formatForPrint();
    }, $courses);
    print_r($courses);
    exit(0);
}

if (isset($options['p']) || isset($options['participants'])) {
    $id = isset($options['p']) ? $options['p'] : $options['participants'];
    echo "Participants of class id $id:".PHP_EOL;
    $users = getUserService()->getAllStudentsByCourseId($id);
    $users = array_map(function ($user) {
        return $user->formatForPrint();
    }, $users);
    print_r($users);
    exit(0);
}

if (isset($options['t']) || isset($options['teachers'])) {
    $id = isset($options['t']) ? $options['t'] : $options['teachers'];
    echo "Teachers of class id $id:".PHP_EOL;
    $users = getUserService()->getAllTeachersByCourseId($id);
    $users = array_map(function ($user) {
        return $user->formatForPrint();
    }, $users);
    print_r($users);
    exit(0);
}

if (isset($options['c']) || isset($options['create'])) {
    $name = isset($options['c']) ? $options['c'] : $options['create'];
    $location = isset($options['l']) ? $options['l'] : $options['location'] ?? '';
    $course = getCourseService()->addCourse($name, $location);
    echo 'Course created:'.PHP_EOL;
    print_r($course->formatForPrint());
    exit(0);
}

if (isset($options['u']) || isset($options['update'])) {
    $id = isset($options['u']) ? $options['u'] : $options['update'];
    $name = isset($options['n']) ? $options['n'] : $options['name'] ?? '';
    $location = isset($options['l']) ? $options['l'] : $options['location'] ?? '';
    $course = getCourseService()->updateCourse($id, $name, $location);
    echo 'Course updated:'.PHP_EOL;
    print_r($course->formatForPrint());
    exit(0);
}

if (isset($options['d']) || isset($options['delete'])) {
    $id = isset($options['d']) ? $options['d'] : $options['delete'];
    $course = getCourseService()->deleteCourse($id);
    echo 'Course deleted:'.PHP_EOL;
    print_r($course->formatForPrint());
    exit(0);
}

if (isset($options['e']) || isset($options['enroll'])) {
    $courseId = isset($options['e']) ? $options['e'] : $options['enroll'];
    $name = isset($options['n']) ? $options['n'] : $options['name'];
    $user = getEnrolmentService()->enrollUserToCourse($name, $courseId);
    echo "User $name enrolled to course $courseId:".PHP_EOL;
    print_r($user->formatForPrint());
    exit(0);
}

if (isset($options['ue']) || isset($options['unenroll'])) {
    $courseId = isset($options['ue']) ? $options['ue'] : $options['unenroll'];
    $name = isset($options['n']) ? $options['n'] : $options['name'];
    $user = getEnrolmentService()->unEnrollUserFromCourse($name, $courseId);
    echo "User $name unenrolled from course $courseId:".PHP_EOL;
    print_r($user->formatForPrint());
    exit(0);
}
