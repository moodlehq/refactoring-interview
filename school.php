<?php

require_once 'lib.php';
require_once 'SchoolDataManager.php';

$help = "Allows you to print out the entire school dataset currently in memory

Options:
-a, --all       Print out the entire school dataset
-h, --help      Print out this help

Example:
\$ php school.php -a";

// Assume $schoolData is loaded from a JSON file
// $schoolData = returnData();

// print_r($schoolData)

// $schoolDataManager = new SchoolDataManager($schoolData);

// Get all users
// $users = $schoolDataManager->getUsers();
// foreach ($users as $user) {
    // print_r($user->getUserInfo());
// }

// Get all enrollments
// $enrollments = $schoolDataManager->getEnrollments();
// print_r($enrollments);
// foreach ($enrollments as $enrollment) {
//     print_r($enrollment->getEnrollmentInfo());
// }

// Find enrollment by course ID
// $courseId = 1;  // Example course ID
// $enrollment = $schoolDataManager->findEnrollmentByCourseId($courseId);

// if ($enrollment) {
//     echo "Enrollment for course ID $courseId:\n";
//     print_r($enrollment->getEnrollmentInfo());
// } else {
//     echo "No enrollment found for course ID $courseId\n";
// }

print_r(printSchoolData());
